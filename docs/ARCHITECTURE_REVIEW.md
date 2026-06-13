# Architecture Review

## Current Findings

- The app follows a standard Laravel MVC shape, but admin features are mixed across controllers, views, routes, and duplicated layout markup.
- Admin sidebar markup existed in both `resources/views/components/admin-layout.blade.php` and `resources/views/layouts/admin.blade.php`.
- Attendance code was present, but the controller/model/view expected fields that did not match the `attendances` table.
- Root route behavior redirects guests to `/login`, so the stock feature test was out of date.
- Project documentation and responsive test reports are useful during development, but should be moved under `docs/` or archived if they are no longer part of day-to-day maintenance.

## Proposed Structure

```text
app/
  Http/
    Controllers/
      Admin/
        AttendanceController.php
        DashboardController.php
        UserPermissionController.php
        UsersController.php
      Auth/
        LoginController.php
      Member/
        MemberController.php
    Requests/
      Admin/
        StoreAttendanceRequest.php
        StoreUserRequest.php
        UpdateUserPermissionsRequest.php
        UpdateUserRequest.php
      AuditLogIndexRequest.php
    Middleware/
  Models/
    Attendance.php
    AuditLog.php
    Member.php
    User.php
  Policies/
database/
  factories/
  migrations/
  seeders/
docs/
  ARCHITECTURE_REVIEW.md
  FRONTEND_SCRIPT_TAGLISH.md
  RESPONSIVE_DESIGN_TEST_REPORT.md
  RESPONSIVE_DESIGN_TEST_SUMMARY.md
public/
  assets/
  css/
    admin/
resources/
  css/
  js/
  views/
    admin/
      partials/
        sidebar.blade.php
      attendance/
      users/
    auth/
    components/
    layouts/
routes/
  web.php
tests/
  Feature/
  Unit/
```

## Cleanup Recommendations

- Keep one admin layout path long-term. The active admin screens use `<x-admin-layout>`, so `resources/views/layouts/admin.blade.php` can be removed after confirming no legacy pages extend it.
- Move root-level reports into `docs/` to reduce project-root noise.
- Replace broad admin controllers with Form Request classes over time, starting with create/update flows that accept user input.
- Prefer route resources where controller methods match Laravel conventions, and keep admin routes under the single `auth + role:Admin` group.

## Security Measures Added

- Admin-only sidebar links are rendered only for users with the `Admin` role.
- Admin routes remain protected by `auth` and Spatie `role:Admin` middleware.
- Login POST is rate-limited with `throttle:5,1`.
- Attendance input is validated by `StoreAttendanceRequest`, including member/service existence, allowed status values, and duplicate attendance protection per member/date.
- Permission updates are validated by `UpdateUserPermissionsRequest`, so submitted permissions must exist in the permissions table.
- Audit log filters are validated by `AuditLogIndexRequest` before being applied to queries.
- External avatar seed values are URL-encoded before being interpolated into DiceBear URLs.
