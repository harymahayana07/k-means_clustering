<?php

namespace App\Filament\Widgets\Dashboard;

use App\Models\KMEANS;
use Filament\Widgets\Widget;

class KmeansCountWidget extends Widget
{
    protected static ?int $sort = -1;
    protected static bool $isLazy = false;

    /**
     * @var string The view used by the widget.
     */
    protected static string $view = 'filament.widgets.dashboard.kmeans-count-widget';

    /**
     * Dynamically set the view for the widget.
     *
     * @param string $view
     */
    public static function setView(string $view): void
    {
        static::$view = $view;
    }

    /**
     * Get the view data for rendering.
     *
     * @return array
     */
    protected function getViewData(): array
    {
        $kmeansCount = KMEANS::count();
        
        return [
            'kmeansCount' => $kmeansCount,
        ];
    }
}
