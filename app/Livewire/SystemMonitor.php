<?php

namespace App\Livewire;

use Livewire\Component;

class SystemMonitor extends Component
{
    public $diskUsage = [];
    public $memoryUsage = [];
    public $cpuLoad;
    public $alerts = [];

    public function mount()
    {
        $this->updateStats();
    }

    public function updateStats()
{
    // Clear previous alerts to avoid duplicates
    $this->alerts = [];

    // Disk
    $diskTotal = @disk_total_space("/");
    $diskFree = @disk_free_space("/");
    
    if ($diskTotal === false || $diskFree === false) {
        $this->diskUsage = ['used' => 0, 'free' => 0, 'percent' => 0];
        $this->alerts[] = "⚠️ Unable to read disk information";
    } else {
        $diskUsed = $diskTotal - $diskFree;
        $diskPercent = ($diskUsed / $diskTotal) * 100;

        if ($diskPercent > 80) $this->alerts[] = "⚠️ Disk usage is above 80%";

        $this->diskUsage = [
            'used' => round($diskUsed / 1e+9, 2),
            'free' => round($diskFree / 1e+9, 2),
            'percent' => round($diskPercent, 1),
        ];
    }

    // Memory
    if (is_readable("/proc/meminfo")) {
        $meminfo = file_get_contents("/proc/meminfo");
        preg_match("/MemTotal:\s+(\d+)/", $meminfo, $matchesTotal);
        preg_match("/MemAvailable:\s+(\d+)/", $meminfo, $matchesFree);
        $memTotal = $matchesTotal[1] ?? 0;
        $memAvailable = $matchesFree[1] ?? 0;
        $memUsed = $memTotal - $memAvailable;
        $memPercent = ($memUsed / $memTotal) * 100;

        if ($memPercent > 80) $this->alerts[] = "⚠️ RAM usage is above 80%";

        $this->memoryUsage = [
            'used' => round($memUsed / 1024, 1),
            'available' => round($memAvailable / 1024, 1),
            'percent' => round($memPercent, 1),
        ];
    } else {
        $this->memoryUsage = ['used' => 0, 'available' => 0, 'percent' => 0];
        $this->alerts[] = "⚠️ Unable to read memory information";
    }

    // CPU
    $load = @sys_getloadavg();
    $this->cpuLoad = $load[0] ?? 0;
}



    public function render()
    {
        $this->updateStats();
        return view('livewire.system-monitor');
    }
}
