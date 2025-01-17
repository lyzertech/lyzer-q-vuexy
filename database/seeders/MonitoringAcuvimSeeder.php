<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // For database operations

class MonitoringAcuvimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the directory to search for files
        $directory = '/FTP'; // Root of `storage/app`
        $oldDirectory = 'old/FTP'; // Target directory for processed files

        // Get all JSON files in the directory
        $files = Storage::files($directory);

        foreach ($files as $file) {
            // Process only JSON files
            if (pathinfo($file, PATHINFO_EXTENSION) === 'json') {
                // Load JSON file
                $jsonData = json_decode(Storage::get($file), true);

                if (!$jsonData) {
                    $this->command->error("Invalid JSON format in file: $file");
                    continue;
                }

                // Extract common data
                $gateway = $jsonData['gateway'];
                $device = $jsonData['device'];
                $timestamps = $jsonData['timestamp'];
                $readings = $device['readings'];

                // Loop through each timestamp
                foreach ($timestamps as $index => $timestamp) {
                    $data = [
                        'gateway_name' => $gateway['name'] ?? 'Unknown Gateway',
                        'gateway_model' => $gateway['model'] ?? 'Unknown Model',
                        'gateway_serial' => $gateway['serial'] ?? 'Unknown Serial',
                        'device_name' => $device['name'] ?? 'Unknown Device',
                        'device_model' => $device['model'] ?? 'Unknown Model',
                        'device_serial' => $device['serial'] ?? 'Unknown Serial',
                        'device_online' => $device['online'] ?? false,
                        'Timestamp' => $timestamp,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    // Add readings for each parameter
                    foreach ($readings as $reading) {
                        $param = $reading['param'];
                        $data[$param] = $reading['value'][$index] ?? null; // Handle missing values
                    }

                    try {
                        DB::table('monitoring_acuvim')->insert($data);
                    } catch (\Exception $e) {
                        $this->command->error("Failed to insert data for timestamp: $timestamp. Error: " . $e->getMessage());
                    }
                }

                Storage::makeDirectory($oldDirectory);
                Storage::move($file, $oldDirectory . '/' . basename($file));
            }
        }
        $this->command->info("All JSON files have been processed.");
    }
}
