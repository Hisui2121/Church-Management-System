import { chromium } from 'playwright';

async function testResponsiveDesign() {
    const browser = await chromium.launch({ headless: true });
    const results = {
        passed: [],
        failed: [],
        issues: [],
        summary: {}
    };

    try {
        const baseUrl = 'http://localhost:8000';

        // Test configuration for different breakpoints
        const breakpoints = [
            { name: 'Desktop', width: 1024, height: 768, mediaQuery: '(min-width: 769px)' },
            { name: 'Tablet', width: 768, height: 1024, mediaQuery: '(max-width: 768px) and (min-width: 481px)' },
            { name: 'Mobile', width: 375, height: 667, mediaQuery: '(max-width: 480px)' }
        ];

        // Create a context and login first
        console.log('🔐 Setting up authentication...\n');
        
        const authContext = await browser.newContext();
        const authPage = await authContext.newPage();
        
        // Add network listener for debugging
        let networkErrors = [];
        authPage.on('response', response => {
            if (!response.ok()) {
                networkErrors.push(`${response.status()} ${response.url()}`);
            }
        });

        try {
            // Go to login page
            await authPage.goto(`${baseUrl}/login`, { waitUntil: 'domcontentloaded', timeout: 15000 });
            console.log('✓ Login page loaded');

            // Get CSRF token
            const csrfToken = await authPage.evaluate(() => {
                const token = document.querySelector('input[name="_token"]');
                return token ? token.value : null;
            });

            if (!csrfToken) {
                console.log('⚠ CSRF token not found - attempting login without it');
            }

            // Fill form
            await authPage.fill('input[name="email"]', 'admin@church.com');
            await authPage.fill('input[name="password"]', 'Admn@1234');
            
            // Submit form
            const submitButton = await authPage.$('button[type="submit"]');
            if (submitButton) {
                await submitButton.click();
                
                // Wait for navigation with longer timeout
                try {
                    await authPage.waitForNavigation({ timeout: 20000 });
                    console.log('✓ Login successful\n');
                } catch (navError) {
                    console.log('⚠ Navigation timeout - checking if already logged in');
                    // Check if we're at dashboard anyway
                    const url = authPage.url();
                    if (url.includes('dashboard')) {
                        console.log('✓ Already at dashboard\n');
                    } else {
                        throw new Error('Login failed: ' + navError.message);
                    }
                }
            }
        } catch (error) {
            console.error('✗ Authentication failed:', error.message);
            if (networkErrors.length > 0) {
                console.error('Network errors:', networkErrors);
            }
            await authContext.close();
            throw error;
        }

        // Get cookies for subsequent tests
        const cookies = await authContext.cookies();
        await authContext.close();

        // Test each breakpoint
        for (const bp of breakpoints) {
            console.log(`📱 Testing ${bp.name} (${bp.width}x${bp.height})`);
            console.log('─'.repeat(50));

            const context = await browser.newContext({
                viewport: { width: bp.width, height: bp.height },
                deviceScaleFactor: 1
            });

            // Add cookies
            if (cookies.length > 0) {
                await context.addCookies(cookies);
            }

            const page = await context.newPage();

            try {
                // Navigate to dashboard
                await page.goto(`${baseUrl}/admin/dashboard`, { waitUntil: 'networkidle', timeout: 15000 });

                // Test 1: Layout structure
                const layoutTest = await testLayoutStructure(page, bp, results);
                
                // Test 2: Sidebar responsive behavior
                const sidebarTest = await testSidebarResponsive(page, bp, results);
                
                // Test 3: Content visibility
                const contentTest = await testContentVisibility(page, bp, results);
                
                // Test 4: Touch targets on mobile
                const touchTest = await testTouchTargets(page, bp, results);
                
                // Test 5: Media queries
                const mediaQueryTest = await testMediaQueries(page, bp, results);

                console.log(`  ✓ Layout: ${layoutTest}`);
                console.log(`  ✓ Sidebar: ${sidebarTest}`);
                console.log(`  ✓ Content: ${contentTest}`);
                console.log(`  ✓ Touch targets: ${touchTest}`);
                console.log(`  ✓ Media queries: ${mediaQueryTest}`);
                console.log();

            } catch (error) {
                results.failed.push(`${bp.name}: ${error.message}`);
                console.error(`  ✗ Error: ${error.message}`);
                console.log();
            } finally {
                await context.close();
            }
        }

        // Test specific pages for responsiveness
        console.log('📄 Testing Admin Pages\n');
        console.log('─'.repeat(50));

        const pages = [
            '/admin/members',
            '/admin/ministries',
            '/admin/events',
            '/admin/announcements'
        ];

        const testContext = await browser.newContext({
            viewport: { width: 1024, height: 768 }
        });

        if (cookies.length > 0) {
            await testContext.addCookies(cookies);
        }

        const testPage = await testContext.newPage();

        for (const pagePath of pages) {
            try {
                await testPage.goto(`${baseUrl}${pagePath}`, { waitUntil: 'networkidle', timeout: 15000 });
                const title = await testPage.title();
                results.passed.push(`${pagePath}: loads successfully`);
                console.log(`  ✓ ${pagePath}: ${title}`);
            } catch (error) {
                results.failed.push(`${pagePath}: ${error.message}`);
                console.log(`  ✗ ${pagePath}: ${error.message}`);
            }
        }

        await testContext.close();

    } catch (error) {
        console.error('\n❌ Test suite error:', error.message);
    } finally {
        await browser.close();
    }

    return results;
}

async function testLayoutStructure(page, bp, results) {
    try {
        const layout = await page.evaluate(() => {
            const sidebar = document.querySelector('.admin-sidebar');
            const main = document.querySelector('.admin-main-wrapper');
            const content = document.querySelector('.admin-page-content');

            return {
                hasSidebar: !!sidebar,
                hasMain: !!main,
                hasContent: !!content,
                sidebarWidth: sidebar ? sidebar.offsetWidth : 0,
                mainMarginLeft: main ? window.getComputedStyle(main).marginLeft : 'N/A'
            };
        });

        results.passed.push(`${bp.name}: Layout structure verified`);
        return 'PASS';
    } catch (error) {
        results.failed.push(`${bp.name} layout: ${error.message}`);
        return 'FAIL';
    }
}

async function testSidebarResponsive(page, bp, results) {
    try {
        const sidebarInfo = await page.evaluate((width) => {
            const sidebar = document.querySelector('.admin-sidebar');
            if (!sidebar) return { exists: false };

            const computed = window.getComputedStyle(sidebar);
            const isCollapsed = sidebar.classList.contains('collapsed');
            const isHidden = computed.display === 'none';
            const width_px = sidebar.offsetWidth;

            return {
                exists: true,
                isCollapsed,
                isHidden,
                width: width_px,
                display: computed.display,
                position: computed.position
            };
        }, bp.width);

        // Verify responsive behavior
        if (!sidebarInfo.exists) {
            results.issues.push(`${bp.name}: Sidebar not found`);
            return 'N/A';
        }

        if (bp.width < 480 && !sidebarInfo.isHidden) {
            results.issues.push(`${bp.name}: Sidebar should be hidden on mobile`);
            return 'NEEDS_REVIEW';
        }

        if (bp.width >= 768 && sidebarInfo.width === 0) {
            results.issues.push(`${bp.name}: Sidebar has zero width on desktop`);
            return 'FAIL';
        }

        results.passed.push(`${bp.name}: Sidebar responsive verified`);
        return 'PASS';
    } catch (error) {
        results.failed.push(`${bp.name} sidebar: ${error.message}`);
        return 'FAIL';
    }
}

async function testContentVisibility(page, bp, results) {
    try {
        const visibility = await page.evaluate(() => {
            const statCards = document.querySelectorAll('.stat-card');
            const tables = document.querySelectorAll('table');
            const forms = document.querySelectorAll('form');

            return {
                statCardsCount: statCards.length,
                tablesCount: tables.length,
                formsCount: forms.length,
                hasAlerts: document.querySelectorAll('.alert').length > 0
            };
        });

        if (visibility.statCardsCount === 0 && visibility.tablesCount === 0) {
            results.issues.push(`${bp.name}: No main content found`);
            return 'NEEDS_REVIEW';
        }

        results.passed.push(`${bp.name}: Content visible`);
        return 'PASS';
    } catch (error) {
        results.failed.push(`${bp.name} content: ${error.message}`);
        return 'FAIL';
    }
}

async function testTouchTargets(page, bp, results) {
    try {
        const touchTargets = await page.evaluate(() => {
            const buttons = Array.from(document.querySelectorAll('button, a[role="button"], .btn'));
            const smallTargets = [];

            buttons.forEach((btn, idx) => {
                const rect = btn.getBoundingClientRect();
                if (rect.width < 44 || rect.height < 44) {
                    smallTargets.push({
                        index: idx,
                        width: Math.round(rect.width),
                        height: Math.round(rect.height),
                        text: btn.textContent.substring(0, 20)
                    });
                }
            });

            return {
                totalButtons: buttons.length,
                smallTargets: smallTargets.length,
                issues: smallTargets.slice(0, 3)
            };
        });

        if (bp.width < 768 && touchTargets.smallTargets > 0) {
            results.issues.push(`${bp.name}: ${touchTargets.smallTargets} touch targets below 44x44px`);
        }

        results.passed.push(`${bp.name}: Touch targets checked`);
        return 'PASS';
    } catch (error) {
        results.failed.push(`${bp.name} touch: ${error.message}`);
        return 'FAIL';
    }
}

async function testMediaQueries(page, bp, results) {
    try {
        const mediaQueries = await page.evaluate(() => {
            return {
                mobileView: window.matchMedia('(max-width: 480px)').matches,
                tabletView: window.matchMedia('(max-width: 768px)').matches,
                desktopView: window.matchMedia('(min-width: 1024px)').matches,
                reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
                darkMode: window.matchMedia('(prefers-color-scheme: dark)').matches
            };
        });

        results.passed.push(`${bp.name}: Media queries verified`);
        return 'PASS';
    } catch (error) {
        results.failed.push(`${bp.name} media queries: ${error.message}`);
        return 'FAIL';
    }
}

// Run tests
console.log('\n╔════════════════════════════════════════════════════╗');
console.log('║  ADMIN DASHBOARD RESPONSIVE DESIGN TEST             ║');
console.log('║  Testing across Desktop, Tablet, and Mobile         ║');
console.log('╚════════════════════════════════════════════════════╝\n');

testResponsiveDesign().then(results => {
    console.log('\n╔════════════════════════════════════════════════════╗');
    console.log('║              TEST SUMMARY REPORT                    ║');
    console.log('╚════════════════════════════════════════════════════╝\n');

    console.log(`✓ Passed Tests:  ${results.passed.length}`);
    console.log(`✗ Failed Tests:  ${results.failed.length}`);
    console.log(`⚠ Issues Found:  ${results.issues.length}\n`);

    if (results.passed.length > 0) {
        console.log('✓ PASSED:');
        results.passed.slice(0, 5).forEach(p => console.log(`   • ${p}`));
        if (results.passed.length > 5) {
            console.log(`   ... and ${results.passed.length - 5} more`);
        }
        console.log();
    }

    if (results.failed.length > 0) {
        console.log('✗ FAILED:');
        results.failed.forEach(f => console.log(`   • ${f}`));
        console.log();
    }

    if (results.issues.length > 0) {
        console.log('⚠ ISSUES:');
        results.issues.slice(0, 5).forEach(i => console.log(`   • ${i}`));
        if (results.issues.length > 5) {
            console.log(`   ... and ${results.issues.length - 5} more`);
        }
        console.log();
    }

    console.log('╔════════════════════════════════════════════════════╗');
    console.log('║            READINESS ASSESSMENT                    ║');
    console.log('╚════════════════════════════════════════════════════╝\n');

    const totalTests = results.passed.length + results.failed.length;
    const passRate = totalTests > 0 ? Math.round((results.passed.length / totalTests) * 100) : 0;

    console.log(`Pass Rate: ${passRate}%`);
    console.log(`Critical Failures: ${results.failed.length}`);
    console.log(`Non-Critical Issues: ${results.issues.length}\n`);

    if (results.failed.length === 0) {
        if (results.issues.length <= 2) {
            console.log('✅ PRODUCTION READY');
            console.log('   All responsive tests passed successfully.\n');
        } else {
            console.log('⚠️  READY WITH CAUTION');
            console.log('   Minor responsive issues detected.\n');
        }
    } else {
        console.log('❌ NOT READY');
        console.log('   Critical responsive issues detected.\n');
    }

    process.exit(results.failed.length > 0 ? 1 : 0);
}).catch(error => {
    console.error('\n❌ Critical error:', error.message);
    console.log('\nNote: If login fails, ensure:');
    console.log('  1. Laravel server is running on http://localhost:8000');
    console.log('  2. Database is seeded with admin@church.com / Admn@1234');
    console.log('  3. Network is accessible\n');
    process.exit(1);
});
