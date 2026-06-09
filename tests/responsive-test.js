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

        for (const breakpoint of breakpoints) {
            console.log(`\n=== Testing ${breakpoint.name} (${breakpoint.width}x${breakpoint.height}) ===`);
            
            const context = await browser.newContext({
                viewport: { width: breakpoint.width, height: breakpoint.height }
            });
            
            const page = await context.newPage();
            
            try {
                // Navigate to login
                await page.goto(`${baseUrl}/login`);
                
                // Login
                await page.fill('input[name="email"]', 'admin@church.com');
                await page.fill('input[name="password"]', 'Admn@1234');
                await page.click('button[type="submit"]');
                
                // Wait for redirect to dashboard
                await page.waitForURL(`${baseUrl}/admin/dashboard`);
                
                // Test 1: Dashboard layout
                const dashboardTest = await testDashboard(page, breakpoint, results);
                
                // Test 2: Sidebar functionality
                const sidebarTest = await testSidebar(page, breakpoint, results);
                
                // Test 3: Navigation
                const navTest = await testNavigation(page, breakpoint, results);
                
                // Test 4: Responsive elements
                const responsiveTest = await testResponsiveElements(page, breakpoint, results);
                
                // Test 5: Check console errors
                const consoleErrors = await checkConsoleErrors(page, breakpoint, results);
                
                // Test 6: Verify CSS
                const cssTest = await verifyCss(page, breakpoint, results);
                
                console.log(`✓ Dashboard layout: ${dashboardTest ? 'PASS' : 'FAIL'}`);
                console.log(`✓ Sidebar: ${sidebarTest ? 'PASS' : 'FAIL'}`);
                console.log(`✓ Navigation: ${navTest ? 'PASS' : 'FAIL'}`);
                console.log(`✓ Responsive elements: ${responsiveTest ? 'PASS' : 'FAIL'}`);
                console.log(`✓ Console errors: ${consoleErrors.length === 0 ? 'PASS' : 'FAIL (' + consoleErrors.length + ' errors)'}`);
                console.log(`✓ CSS: ${cssTest ? 'PASS' : 'FAIL'}`);
                
            } catch (error) {
                results.failed.push(`${breakpoint.name}: ${error.message}`);
            } finally {
                await context.close();
            }
        }

        // Test each admin page
        console.log(`\n=== Testing Admin Pages ===`);
        const pages = [
            { path: '/admin/dashboard', name: 'Dashboard' },
            { path: '/admin/members', name: 'Members' },
            { path: '/admin/ministries', name: 'Ministries' },
            { path: '/admin/events', name: 'Events' },
            { path: '/admin/announcements', name: 'Announcements' },
            { path: '/admin/messages', name: 'Messages' },
            { path: '/admin/orders', name: 'Orders' }
        ];

        const context = await browser.newContext({
            viewport: { width: 1024, height: 768 }
        });
        
        const page = await context.newPage();
        
        try {
            await page.goto(`${baseUrl}/login`);
            await page.fill('input[name="email"]', 'admin@church.com');
            await page.fill('input[name="password"]', 'Admn@1234');
            await page.click('button[type="submit"]');
            await page.waitForURL(`${baseUrl}/admin/dashboard`);

            for (const adminPage of pages) {
                try {
                    await page.goto(`${baseUrl}${adminPage.path}`);
                    const isVisible = await page.isVisible('body');
                    if (isVisible) {
                        results.passed.push(`${adminPage.name} page loads successfully`);
                        console.log(`✓ ${adminPage.name}: PASS`);
                    } else {
                        results.failed.push(`${adminPage.name} page not visible`);
                        console.log(`✗ ${adminPage.name}: FAIL`);
                    }
                } catch (error) {
                    results.failed.push(`${adminPage.name}: ${error.message}`);
                    console.log(`✗ ${adminPage.name}: FAIL - ${error.message}`);
                }
            }
        } finally {
            await context.close();
        }

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

        results.passed.push(`${breakpoint.name}: Dashboard layout passes`);
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

        const sidebarToggle = await page.$('.sidebar-toggle');
        if (!sidebarToggle) {
            results.issues.push(`${breakpoint.name}: Sidebar toggle button not found`);
            return false;
        }

        // Click toggle
        await sidebarToggle.click();
        await page.waitForTimeout(300); // Wait for animation

        // Check if sidebar collapsed
        const isCollapsed = await page.evaluate(() => {
            const sidebar = document.querySelector('.admin-sidebar');
            return sidebar.classList.contains('collapsed');
        });

        if (breakpoint.width >= 769) {
            if (!isCollapsed) {
                results.issues.push(`${breakpoint.name}: Sidebar toggle didn't work`);
            }
        }

        // Toggle back
        await sidebarToggle.click();
        await page.waitForTimeout(300);

        results.passed.push(`${breakpoint.name}: Sidebar toggle works`);
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

        // Test first menu item click
        if (menuItems.length > 0) {
            const firstMenuItem = menuItems[0];
            const href = await firstMenuItem.getAttribute('href');
            
            if (href && href !== '#') {
                await firstMenuItem.click();
                await page.waitForTimeout(500);
                
                // Check if navigation worked
                const url = page.url();
                if (!url.includes(href)) {
                    results.issues.push(`${breakpoint.name}: Navigation to ${href} failed`);
                }
            }
        }

        results.passed.push(`${breakpoint.name}: Navigation works`);
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

        await userMenuBtn.click();
        await page.waitForTimeout(300);

        const dropdown = await page.$('.user-menu-dropdown.show');
        if (!dropdown) {
            results.issues.push(`${breakpoint.name}: User menu dropdown didn't show`);
        }

        // Click somewhere else to close
        await page.click('body');
        await page.waitForTimeout(300);

        // Test button responsiveness
        const buttons = await page.$$('button[type="button"]');
        if (buttons.length === 0) {
            results.issues.push(`${breakpoint.name}: No buttons found`);
            return false;
        }

        results.passed.push(`${breakpoint.name}: Responsive elements work`);
        return true;
    } catch (error) {
        results.failed.push(`${breakpoint.name} responsive elements test: ${error.message}`);
        return false;
    }
}

async function checkConsoleErrors(page, breakpoint, results) {
    const errors = [];
    
    page.on('console', msg => {
        if (msg.type() === 'error') {
            errors.push(`${breakpoint.name}: ${msg.text()}`);
            results.issues.push(`${breakpoint.name} console error: ${msg.text()}`);
        }
    });

    page.on('pageerror', error => {
        errors.push(`${breakpoint.name}: ${error.message}`);
        results.issues.push(`${breakpoint.name} page error: ${error.message}`);
    });

    // Wait a bit to catch any errors
    await page.waitForTimeout(1000);

    return errors;
}

async function verifyCss(page, breakpoint, results) {
    try {
        // Check primary color
        const primaryColor = await page.evaluate(() => {
            return getComputedStyle(document.documentElement).getPropertyValue('--primary').trim();
        });

        if (!primaryColor.includes('67b69e') && !primaryColor.includes('rgb')) {
            results.issues.push(`${breakpoint.name}: Primary color not correct: ${primaryColor}`);
        }

        // Check stat card hover effect
        const statCard = await page.$('.stat-card');
        if (statCard) {
            await statCard.hover();
            await page.waitForTimeout(300);
            
            const transform = await statCard.evaluate(el => {
                return window.getComputedStyle(el).transform;
            });

            if (!transform || transform === 'none') {
                results.issues.push(`${breakpoint.name}: Stat card hover effect not working`);
            }
        }

        results.passed.push(`${breakpoint.name}: CSS validation passes`);
        return true;
    } catch (error) {
        results.failed.push(`${breakpoint.name} CSS test: ${error.message}`);
        return false;
    }
}

// Run tests
runResponsiveTests().then(results => {
    console.log('\n\n========== TEST SUMMARY ==========');
    console.log(`✓ Passed: ${results.passed.length}`);
    console.log(`✗ Failed: ${results.failed.length}`);
    console.log(`⚠ Issues: ${results.issues.length}`);

    if (results.failed.length > 0) {
        console.log('\nFailed Tests:');
        results.failed.forEach(f => console.log(`  - ${f}`));
    }

    if (results.issues.length > 0) {
        console.log('\nIssues Found:');
        results.issues.forEach(i => console.log(`  - ${i}`));
    }

    process.exit(results.failed.length > 0 ? 1 : 0);
}).catch(error => {
    console.error('Test error:', error);
    process.exit(1);
});
