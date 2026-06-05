<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('atc')
            ->theme(asset('css/filament/admin/theme.css'))
            ->brandName('SieLata')
            ->brandLogo(asset('images/sielata_logo_53w.gif'))
            ->brandLogoHeight('5rem')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->renderHook(
                'panels::body.end',
                fn() => new \Illuminate\Support\HtmlString('
                    <script>
                        document.addEventListener("mousedown", function(e) {
                            const toggle = e.target.closest(".fi-toggle");
                            const option = e.target.closest(".fi-select-input-option") || e.target.closest(".fi-dropdown-list-item");
                            
                            if (toggle || option) {
                                setTimeout(() => {
                                    document.querySelectorAll("button").forEach(btn => {
                                        if (btn.getAttribute("wire:click") === "applyTableFilters") {
                                            btn.click();
                                        }
                                    });
                                }, 500);
                            }
                        });

                        function hideApplyButton() {
                            setTimeout(() => {
                                document.querySelectorAll("button").forEach(btn => {
                                    if (btn.getAttribute("wire:click") === "applyTableFilters") {
                                        console.log("hiding button");
                                        btn.style.visibility = "hidden";
                                        btn.style.position = "absolute";
                                    }
                                });
                            }, 1000);
                        }

                        document.addEventListener("livewire:navigated", hideApplyButton);
                        document.addEventListener("livewire:updated", hideApplyButton);
                        document.addEventListener("DOMContentLoaded", hideApplyButton);
                    </script>
                ')
            )  
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
