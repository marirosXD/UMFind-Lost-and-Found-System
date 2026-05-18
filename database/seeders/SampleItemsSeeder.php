<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleItemsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'user')->first();
        
        if ($user) {
            Item::create([
                'user_id' => $user->id,
                'title' => 'Lost iPhone 14',
                'description' => 'Lost iPhone 14 Pro Max in black color with a blue case. Last seen at the food court.',
                'category' => 'electronics',
                'location' => 'Mall Food Court',
                'date_found' => '2024-01-15',
                'status' => 'unclaimed',
            ]);
            
            Item::create([
                'user_id' => $user->id,
                'title' => 'Found Student ID',
                'description' => 'Found a student ID card near the library. Name on card: John Doe.',
                'category' => 'documents',
                'location' => 'University Library',
                'date_found' => '2024-01-20',
                'status' => 'unclaimed',
            ]);
            
            Item::create([
                'user_id' => $user->id,
                'title' => 'Lost House Keys',
                'description' => 'Set of 3 keys with a silver keychain. Lost near the parking lot.',
                'category' => 'keys',
                'location' => 'Parking Lot',
                'date_found' => '2024-01-18',
                'status' => 'unclaimed',
            ]);
        }
    }
}