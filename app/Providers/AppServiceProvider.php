<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use App\Models\Peminjaman;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $notificationItems = [];
            $notificationCount = 0;

            if (!Auth::check()) {
                $view->with(compact('notificationItems', 'notificationCount'));
                return;
            }

            $user = Auth::user();
            $baseQuery = Peminjaman::query();
            $actionRoute = route('peminjaman.index');

            switch ($user->role) {
                case 'siswa':
                    $baseQuery = $baseQuery->where('user_id', $user->id);
                    $actionRoute = route('peminjaman.index');
                    break;
                case 'wali_kelas':
                    $baseQuery = $baseQuery->whereHas('user', function ($query) use ($user) {
                        $query->whereRaw('LOWER(major) = ?', [strtolower($user->major)]);
                        if ($user->kelas) {
                            $query->whereRaw('LOWER(kelas) = ?', [strtolower($user->kelas)]);
                        }
                    });
                    $actionRoute = route('wali_kelas.peminjaman');
                    break;
                case 'kaonsli_sij':
                    $baseQuery = $baseQuery->whereHas('user', function ($query) {
                        $query->where('major', 'SIJA');
                    });
                    $actionRoute = route('kaonsli_sij.peminjaman');
                    break;
                case 'kaprog_tkj':
                    $baseQuery = $baseQuery->whereHas('user', function ($query) {
                        $query->where('major', 'TKJ');
                    });
                    $actionRoute = route('kaprog_tkj.peminjaman');
                    break;
                default:
                    $actionRoute = route('peminjaman.index');
                    break;
            }

            $pendingCount = (clone $baseQuery)->where('status', 'pending')->count();
            $overdueCount = (clone $baseQuery)
                ->where('status', '!=', 'returned')
                ->whereNotNull('return_date')
                ->where('return_date', '<', Carbon::now())
                ->count();

            if ($pendingCount > 0) {
                $notificationItems[] = [
                    'title' => 'Peminjaman Menunggu',
                    'message' => "Ada {$pendingCount} peminjaman yang menunggu persetujuan.",
                    'type' => 'info',
                    'action' => $actionRoute,
                ];
            }

            if ($overdueCount > 0) {
                $notificationItems[] = [
                    'title' => 'Peminjaman Terlambat',
                    'message' => "Ada {$overdueCount} peminjaman terlambat dikembalikan.",
                    'type' => 'warning',
                    'action' => $actionRoute,
                ];
            }

            $notificationCount = count($notificationItems);

            if ($notificationCount === 0) {
                $notificationItems[] = [
                    'title' => 'Semua Terkini',
                    'message' => 'Semua aktivitas telah terpantau dan tidak ada notifikasi baru.',
                    'type' => 'success',
                    'action' => $actionRoute,
                ];
            }

            $view->with(compact('notificationItems', 'notificationCount'));
        });
    }
}
