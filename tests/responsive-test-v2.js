import { chromium } from 'playwright';

async function runResponsiveTests() {
    const browser = await chromium.launch();
    const results = {
        passed: [],
        failed: [],
        issues: []
    };

    try {
        // Test configurations
        const breakpoints = [
            { name: 'Desktop', width: 1024, height: 768 },
            { name: 'Tablet', width: 768, height: 1024 },
            { name: 'Mobile', width: 375, height: 667 }
        ];

        const baseUrl = 'http://localhost:8000';

        // First, login once to create a session
        console.log('=== Authenticating ===');
        const context = await browser.newContext();
        const page = await context.newPage();
        
        try {
            await page.goto(`${baseUrl}/login`, { waitUntil: 'networkidle' });
            
            // Wait for email field
            await page.waitForSelector('input[name="email"]', { timeout: 10000 });
            
            // Fill email
            await page.fill('input[name="email"]', 'admin@church.com');
            
            // Fill password
            await page.fill('input[name="password"]', 'Admn@1234');
            
            // Click submit button
            await page.click('button[type="submit"]');
            
            // Wait for navigation
            await page.waitForURL(`${baseUrl}/admin/dashboard`, { timeout: 10000 });
            console.log('✓ Authentication successful');
        } catch (error) {
            console.error('✗ Authentication failed:', error.message);
            results.failed.push(`Authentication: ${error.message}`);
            await context.close();
            throw error;
        }

        // Get cookies from authenticated session
        const cookies = await context.cookies();
        await context.close();

        // Now test each breakpoint
        for (const breakpoint of breakpoints) {
            console.log(`\n=== Testing ${breakpoint.name} (${breakpoint.width}x${breakpoint.height}) ===`);
            
            const testContext = await browser.newContext({
                viewport: { width: breakpoint.width, height: breakpoint.height },
                extraHTTPHeaders: { 'Accept-Language': 'en-US,en;q=0.9' }
            });
            
            // Add cookies to context
            await testContext.addCookies(cookies);
            
            const testPage = await testContext.newPage();
            
            try {
                // Navigate to dashboard
                await testPage.goto(`${baseUrl}/admin/dashboard`, { waitUntil: 'networkidle' });
                
                // Test 1: Dashboard layout
                const dashboardTest = await testDashboard(testPage, breakpoint, results);
                
                // Test 2: Sidebar functionality
                const sidebarTest = await testSidebar(testPage, breakpoint, results);
                
                // Test 3: Navigation
                const navTest = await testNavigation(testPage, breakpoint, results);
                
                // Test 4: Responsive elements
                const responsiveTest = await testResponsiveElements(testPage, breakpoint, results);
                
                // Test 5: Check viewport adjustments
                const viewportTest = await testViewportAdjustments(testPage, breakpoint, results);
                
                console.log(`  ✓ Dashboard layout: ${dashboardTest ? 'PASS' : 'FAIL'}`);
                console.log(`  ✓ Sidebar: ${sidebarTest ? 'PASS' : 'FAIL'}`);
                console.log(`  ✓ Navigation: ${navTest ? 'PASS' : 'FAIL'}`);
                console.log(`  ✓ Responsive elements: ${responsiveTest ? 'PASS' : 'FAIL'}`);
                console.log(`  ✓ Viewport adjustments: ${viewportTest ? 'PASS' : 'FAIL'}`);
                
            } catch (error) {
                results.failed.push(`${breakpoint.name}: ${error.message}`);
                console.error(`  ✗ Error:`, error.message);
            } finally {
                await testContext.close();
            }
        }

        // Test each admin page
        console.log(`\n=== Testing Admin Pages (Desktop view) ===`);
        const pages = [
            { path: '/admin/dashboard', name: 'Dashboard' },
            { path: '/admin/members', name: 'Members' },
            { path: '/admin/ministries', name: 'Ministries' },
            { path: '/admin/events', name: 'Events' },
            { path: '/admin/announcements', name: 'Announcements' },
            { path: '/admin/messages', name: 'Messages' },
            { path: '/admin/orders', name: 'Orders' }
        ];

        const pageContext = await browser.newContext({
            viewport: { width: 1024, height: 768 }
        });
        
        await pageContext.addCookies(cookies);
        const pageTestPage = await pageContext.newPage();
        
        try {
            for (const adminPage of pages) {
                try {
                    await pageTestPage.goto(`${baseUrl}${adminPage.path}`, { waitUntil: 'networkidle' });
                    const isVisible = await pageTestPage.isVisible('body');
                    if (isVisible) {
                        results.passed.push(`${adminPage.name} page loads successfully`);
                        console.log(`  ✓ ${adminPage.name}: PASS`);
                    } else {
                        results.failed.push(`${adminPage.name} page not visible`);
                        console.log(`  ✗ ${adminPage.name}: FAIL - page not visible`);
                    }
                } catch (error) {
                    results.failed.push(`${adminPage.name}: ${error.message}`);
                    console.log(`  ✗ ${adminPage.name}: FAIL - ${error.message}`);
                }
            }
        } finally {
            await pageContext.close();
        }

    } catch (error) {
        console.error('Test suite error:', error.message);
    } finally {
        await browser.close();
    }

    return results;
}

async function testDashboard(page, breakpoint, results) {
    try {
        // Check main dashboard content
        const dashboardContainer = await page.$('.admin-dashboard');
        if (!dashboardContainer) {
            results.issues.push(`${breakpoint.name}: Dashboard container not found`);
            return false;
        }

        // Check stat grid
        const statGrid = await page.$('.stat-grid');
        if (!statGrid) {
            results.issues.push(`${breakpoint.name}: Stat grid not found`);
            return false;
        }

        // Check stat cards count
        const statCards = await page.$$('.stat-card');
        if (statCards.length < 4) {
            results.issues.push(`${breakpoint.name}: Expected at least 4 stat cards, found ${statCards.length}`);
        }

        // Verify stat cards are visible
        for (let i = 0; i < Math.min(2, statCards.length); i++) {
            const isVisible = await statCards[i].isVisible();
            if (!isVisible) {
                results.issues.push(`${breakpoint.name}: Stat card ${i + 1} not visible`);
            }
        }

        // Check responsive layout
        const dashboardGrid = await page.$('.dashboard-grid');
        if (dashboardGrid) {
            const gridCols = await dashboardGrid.evaluate(el => {
                return window.getComputedStyle(el).gridTemplateColumns;
            });
            results.passed.push(`${breakpoint.name}: Dashboard grid layout: ${gridCols}`);
        }

        return true;
    } catch (error) {
        results.failed.push(`${breakpoint.name} dashboard test: ${error.message}`);
        return false;
    }
}

async function testSidebar(page, breakpoint, results) {
    try {
        const sidebar = await page.$('.admin-sidebar');
        if (!sidebar) {
            results.issues.push(`${breakpoint.name}: Sidebar not found`);
            return false;
        }

        // Check sidebar visibility based on breakpoint
        if (breakpoint.width < 480) {
            // Mobile: sidebar should be hidden
            const display = await sidebar.evaluate(el => {
                return window.getComputedStyle(el).display;
            });
            
            if (display !== 'none') {
                results.issues.push(`${breakpoint.name}: Sidebar should be hidden on mobile`);
            }
        } else if (breakpoint.width < 768) {
            // Tablet: sidebar should be collapsed to icons only
            const width = await sidebar.evaluate(el => {
                const style = window.getComputedStyle(el);
                return parseInt(style.width);
            });
            
            if (width > 100) {
                results.issues.push(`${breakpoint.name}: Sidebar should be narrower on tablet (${width}px)`);
            }
        }

        const sidebarToggle = await page.$('.sidebar-toggle');
        if (!sidebarToggle && breakpoint.width >= 480) {
            results.issues.push(`${breakpoint.name}: Sidebar toggle button not found`);
            return false;
        }

        // Try to interact with toggle if it exists
        if (sidebarToggle && breakpoint.width >= 768) {
            await sidebarToggle.click();
            await page.waitForTimeout(300);

            // Check if sidebar collapsed
            const isCollapsed = await page.evaluate(() => {
                const sidebar = document.querySelector('.admin-sidebar');
                return sidebar && sidebar.classList.contains('collapsed');
            });

            if (!isCollapsed) {
                results.issues.push(`${breakpoint.name}: Sidebar toggle didn't work`);
            }

            // Toggle back
            await sidebarToggle.click();
            await page.waitForTimeout(300);
        }

        results.passed.push(`${breakpoint.name}: Sidebar responsive behavior verified`);
        return true;
    } catch (error) {
        results.failed.push(`${breakpoint.name} sidebar test: ${error.message}`);
        return false;
    }
}

async function testNavigation(page, breakpoint, results) {
    try {
        // Get all menu items
        const menuItems = await page.$$('.menu-item');
        if (menuItems.length === 0) {
            results.issues.push(`${breakpoint.name}: No menu items found`);
            return false;
        }

        results.passed.push(`${breakpoint.name}: Navigation menu found with ${menuItems.length} items`);
        return true;
    } catch (error) {
        results.failed.push(`${breakpoint.name} navigation test: ${error.message}`);
        return false;
    }
}

async function testResponsiveElements(page, breakpoint, results) {
    try {
        // Test user menu
        const userMenuBtn = await page.$('.user-menu-btn');
        if (!userMenuBtn) {
            results.issues.push(`${breakpoint.name}: User menu button not found`);
            return false;
        }

        // Check if user menu is clickable
        const isEnabled = await userMenuBtn.evaluate(el => !el.disabled);
        if (!isEnabled) {
            results.issues.push(`${breakpoint.name}: User menu button is disabled`);
            return false;
        }

        // Test button sizes for touch-friendliness on mobile
        if (breakpoint.width < 768) {
            const buttons = await page.$$('button');
            for (let i = 0; i < Math.min(3, buttons.length); i++) {
                const box = await buttons[i].boundingBox();
                if (box && (box.width < 40 || box.height < 40)) {
                    results.issues.push(`${breakpoint.name}: Button ${i + 1} might be too small for touch (${box.width}x${box.height}px)`);
                }
            }
        }

        results.passed.push(`${breakpoint.name}: Responsive elements verified`);
        return true;
    } catch (error) {
        results.failed.push(`${breakpoint.name} responsive elements test: ${error.message}`);
        return false;
    }
}

async function testViewportAdjustments(page, breakpoint, results) {
    try {
        // Test media query breakpoints
        const viewportInfo = await page.evaluate((bp) => {
            return {
                windowWidth: window.innerWidth,
                windowHeight: window.innerHeight,
                breakpoint: bp.width,
                isMobile: window.matchMedia('(max-width: 480px)').matches,
                isTablet: window.matchMedia('(max-width: 768px)').matches,
                mainWrapperMargin: window.getComputedStyle(document.querySelector('.admin-main-wrapper')).marginLeft
            };
        }, breakpoint);

        results.passed.push(`${breakpoint.name}: Viewport ${viewportInfo.windowWidth}x${viewportInfo.windowHeight}, main wrapper margin: ${viewportInfo.mainWrapperMargin}`);

        // Verify correct media queries are applied
        if (breakpoint.width < 480) {
            if (!viewportInfo.isMobile) {
                results.issues.push(`${breakpoint.name}: Mobile media query not detected`);
            }
        }

        if (breakpoint.width < 768) {
            if (!viewportInfo.isTablet) {
                results.issues.push(`${breakpoint.name}: Tablet media query not detected`);
            }
        }

        return true;
    } catch (error) {
        results.failed.push(`${breakpoint.name} viewport test: ${error.message}`);
        return false;
    }
}

// Run tests
runResponsiveTests().then(results => {
    console.log('\n\n========== TEST SUMMARY ==========');
    console.log(`✓ Passed: ${results.passed.length}`);
    console.log(`✗ Failed: ${results.failed.length}`);
    console.log(`⚠ Issues: ${results.issues.length}`);

    if (results.passed.length > 0) {
        console.log('\n✓ Passed Tests:');
        results.passed.forEach(p => console.log(`  - ${p}`));
    }

    if (results.failed.length > 0) {
        console.log('\n✗ Failed Tests:');
        results.failed.forEach(f => console.log(`  - ${f}`));
    }

    if (results.issues.length > 0) {
        console.log('\n⚠ Issues Found:');
        results.issues.forEach(i => console.log(`  - ${i}`));
    }

    console.log('\n========== READINESS ASSESSMENT ==========');
    const totalTests = results.passed.length + results.failed.length;
    const passRate = totalTests > 0 ? Math.round((results.passed.length / totalTests) * 100) : 0;
    
    console.log(`Pass Rate: ${passRate}%`);
    console.log(`Critical Failures: ${results.failed.length}`);
    console.log(`Non-Critical Issues: ${results.issues.length}`);
    
    if (results.failed.length === 0 && results.issues.length <= 2) {
        console.log('\n✓ READY FOR PRODUCTION - All critical tests passed');
    } else if (results.failed.length <= 2) {
        console.log('\n⚠ MOSTLY READY - Minor issues detected, review needed');
    } else {
        console.log('\n✗ NOT READY - Multiple critical issues detected');
    }

    process.exit(results.failed.length > 0 ? 1 : 0);
}).catch(error => {
    console.error('Test error:', error);
    process.exit(1);
});
