<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});
Breadcrumbs::for('admin.inviteVendor', function ($trail) {
    $trail->push(__('strings.backend.inviteVendor.title'), route('admin.inviteVendor'));
});

Breadcrumbs::for('admin.charter-plane', function ($trail) {
    $trail->push(__('Charter Plane Management'), route('admin.charter-plane'));
});

Breadcrumbs::for('admin.charter-plane-add', function ($trail) {
    $trail->push(__('Add Charter Plane details'), route('admin.charter-plane-add'));
});

Breadcrumbs::for('admin.charter-plane-edit', function ($trail) {
    $trail->push(__('Edit Charter Plane details'), route('admin.charter-plane'));
});

Breadcrumbs::for('admin.add-charter-details', function ($trail) {
    $trail->push(__('Add Charter Details'), route('admin.add-charter-details'));
});
Breadcrumbs::for('admin.charter-details', function ($trail) {
    $trail->push(__('Charter Details'), route('admin.charter-details'));
});
Breadcrumbs::for('admin.edit-charter-details', function ($trail) {
    $trail->push(__('Edit Charter Details'), route('admin.charter-details'));
});
Breadcrumbs::for('admin.flight-details', function ($trail) {
    $trail->push(__('All Charter Flight Details'), route('admin.flight-details'));
});
Breadcrumbs::for('admin.flight-details-add', function ($trail) {
    $trail->push(__('Add Charter Flight Details'), route('admin.flight-details'));
});
Breadcrumbs::for('admin.flight-details-edit', function ($trail) {
    $trail->push(__('Edit Charter Flight Details'), route('admin.flight-details'));
});
Breadcrumbs::for('admin.charter-booking', function ($trail) {
    $trail->push(__('All Booking'), route('admin.charter-booking'));
});
Breadcrumbs::for('admin.charter-booking-details', function ($trail) {
    $trail->push(__('Booking Details'), route('admin.charter-booking'));
});
require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';
