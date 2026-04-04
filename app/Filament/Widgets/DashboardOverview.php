<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Categories;
use App\Models\Complaints;
use App\Models\News;
use App\Models\Slider;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Sliders', Slider::count())
                ->description('Count of all sliders')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Categories', Categories::count())
                ->description('Count of all categories')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Articles Published', Article::where('status', 'published')->count())
                ->description('Count of all articles')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('News', News::where('status', 'published')->count())
                ->description('Count of all news')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Users', User::count())
                ->description('Count of all users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Complaints', Complaints::count())
                ->description('Count of all complaints posted')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('primary'),
        ];
    }
}
