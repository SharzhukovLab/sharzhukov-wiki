<?php

use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\WikiCategoryController;
use App\Http\Controllers\WikiHomeController;
use App\Http\Controllers\WikiPageController;
use App\Http\Controllers\WikiSearchController;
use App\Http\Controllers\WikiTagController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WikiHomeController::class, 'index'])->name('wiki.home');

Route::get('/categories', [WikiCategoryController::class, 'index'])->name('wiki.categories');
Route::get('/c/{category:slug}', [WikiCategoryController::class, 'show'])->name('wiki.category');

Route::get('/pages', [WikiPageController::class, 'index'])->name('wiki.pages');
Route::get('/p/{page:slug}', [WikiPageController::class, 'show'])->name('wiki.page');

Route::get('/tags', [WikiTagController::class, 'index'])->name('wiki.tags');
Route::get('/t/{tag:slug}', [WikiTagController::class, 'show'])->name('wiki.tag');

Route::get('/search', [WikiSearchController::class, 'index'])->name('wiki.search');

Route::post('/api/cookie-consent', [CookieConsentController::class, 'store'])->name('cookie-consent.store');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/confirm/{token}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// ─── SEO ───
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// ── Notifications ──
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationsController::class, 'index'])->name('notifications.index');
    Route::get('/api/notifications/recent', [\App\Http\Controllers\NotificationsController::class, 'recent'])->name('notifications.recent');
    Route::get('/api/notifications/unread-count', [\App\Http\Controllers\NotificationsController::class, 'unreadCount'])->name('notifications.unread');
    Route::post('/api/notifications/{id}/read', [\App\Http\Controllers\NotificationsController::class, 'markRead'])->name('notifications.read');
    Route::post('/api/notifications/mark-all-read', [\App\Http\Controllers\NotificationsController::class, 'markAllRead'])->name('notifications.mark-all');
    Route::delete('/api/notifications/{id}', [\App\Http\Controllers\NotificationsController::class, 'destroy'])->name('notifications.destroy');
});
