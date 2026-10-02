<?php

use App\Http\Controllers\Dcp\ContactController;
use App\Http\Controllers\Dcp\IdaCampaignController;
use Illuminate\Support\Facades\Route;
use Solaris\Core\Helpers\Helper;

Route::prefix('dcp')->name('dcp.')->group(function () {
    // 1. Contact Management under CDP
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/contact/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
    Route::get('/contact/profile/{id}', [ContactController::class, 'getProfile'])->name('contact.profile');
    Route::post('/contact/apply-enrichment-filter', [ContactController::class, 'applyFilter'])->name('contact.filter');
    Route::post('/contact/{id}/enrich', [ContactController::class, 'enrichContact'])->name('contact.enrich');
    Route::get('/contact/{id}', [ContactController::class, 'show'])->name('contact.show');

    // Legacy Fallback Redirects (Enrichment, Cleansing, Research -> Contact)
    Route::get('/enrichment', fn () => redirect()->route('dcp.contact'))->name('enrichment');
    Route::get('/enrichment/{id}', fn () => redirect()->route('dcp.contact'))->name('enrichment.show');
    Route::get('/cleansing', fn () => redirect()->route('dcp.contact'))->name('cleansing');
    Route::get('/research', fn () => redirect()->route('dcp.contact'))->name('research');

    // 4. Campaign & Blasting - Email
    Route::get('/campaign', function () {
        $breadcrumbs = [
            ['label' => 'CDP'],
            ['label' => 'Campaign & Blasting'],
            ['label' => 'Email']
        ];

        return view(Helper::view("email_blast.list"), [
            'breadcrumbs' => $breadcrumbs
        ]);
    })->name('campaign');

    Route::get('/campaign/email', function () {
        return redirect()->route('dcp.campaign');
    })->name('campaign.email');

    // 5. Campaign & Blasting - WhatsApp
    Route::get('/campaign/whatsapp', function () {
        $breadcrumbs = [
            ['label' => 'CDP'],
            ['label' => 'Campaign & Blasting'],
            ['label' => 'WhatsApp']
        ];

        return view('dcp.campaign.whatsapp-list', [
            'breadcrumbs' => $breadcrumbs
        ]);
    })->name('campaign.whatsapp');

    // WhatsApp Campaign Detail / Edit under DCP (keeps CDP active in sidebar)
    Route::get('/campaign/whatsapp/edit/{id}', [IdaCampaignController::class, 'showCampaign'])->name('campaign.whatsapp.edit');
    Route::get('/campaign/whatsapp/{id}', [IdaCampaignController::class, 'showCampaign'])->name('campaign.whatsapp.show');

    // 6. IDA Campaign Integration Endpoints
    Route::get('/campaign/ida/{blastId}', [IdaCampaignController::class, 'getConfig'])->name('campaign.ida.get');
    Route::post('/campaign/ida/{blastId}/apply-filter', [IdaCampaignController::class, 'applyFilter'])->name('campaign.ida.apply');
    Route::post('/campaign/ida/{blastId}/simulate-consent', [IdaCampaignController::class, 'simulateConsent'])->name('campaign.ida.consent');
    Route::post('/campaign/ida/{blastId}/reset-simulation', [IdaCampaignController::class, 'resetSimulation'])->name('campaign.ida.reset');
    Route::post('/campaign/ida/{blastId}/push-audience', [IdaCampaignController::class, 'pushToAudience'])->name('campaign.ida.push');

    // Alias redirects
    Route::get('/email-blast', function () {
        return redirect()->route('dcp.campaign');
    });

    Route::get('/wa-blast', function () {
        return redirect()->route('dcp.campaign.whatsapp');
    });
});
