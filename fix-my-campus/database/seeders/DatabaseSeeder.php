<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\ComplaintStatusLog;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = collect([
            'admin' => 'Authority role for assignment, monitoring, and reports.',
            'student' => 'Student role for complaint submission and feedback.',
            'staff' => 'Maintenance staff role for assigned work and progress notes.',
        ])->mapWithKeys(fn ($description, $name) => [
            $name => Role::firstOrCreate(
                ['role_name' => $name],
                ['description' => $description]
            ),
        ]);

        $admin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'role_id' => $roles['admin']->id,
                'name' => 'Campus Authority',
                'password' => Hash::make('password'),
                'department' => 'Operations',
                'designation' => 'Maintenance Coordinator',
                'status' => 'active',
            ]
        );

        $student = User::updateOrCreate(
            ['email' => 'student@fixmycampus.test'],
            [
                'role_id' => $roles['student']->id,
                'name' => 'Ayesha Rahman',
                'password' => Hash::make('password'),
                'student_id' => 'CSE-2026-014',
                'department' => 'CSE Batch 2026',
                'status' => 'active',
            ]
        );

        $staff = User::updateOrCreate(
            ['email' => 'staff@fixmycampus.test'],
            [
                'role_id' => $roles['staff']->id,
                'name' => 'Maintenance Staff',
                'password' => Hash::make('password'),
                'staff_id' => 'MNT-102',
                'department' => 'Facilities',
                'designation' => 'Electrical and Network Support',
                'status' => 'active',
            ]
        );

        $categories = collect([
            'Wi-Fi' => 'Internet connectivity and campus network issues.',
            'Electricity' => 'Power sockets, lighting, fan, and electrical safety issues.',
            'Water' => 'Water supply, leakage, and plumbing issues.',
            'Cleaning' => 'Sanitation, waste, and general cleanliness issues.',
            'Classroom' => 'Furniture, projector, board, and room readiness issues.',
            'Lab' => 'Computer lab, equipment, and technical classroom issues.',
        ])->mapWithKeys(fn ($description, $name) => [
            $name => ComplaintCategory::firstOrCreate(
                ['category_name' => $name],
                ['description' => $description, 'status' => 'active']
            ),
        ]);

        $locations = collect([
            ['location_name' => 'CSE Lab', 'building_name' => 'Academic Building', 'floor_no' => '2nd floor', 'room_no' => '204'],
            ['location_name' => 'Main Classroom', 'building_name' => 'Academic Building', 'floor_no' => '1st floor', 'room_no' => '103'],
            ['location_name' => 'Library Reading Area', 'building_name' => 'Central Library', 'floor_no' => 'Ground floor', 'room_no' => null],
            ['location_name' => 'Cafeteria Wash Area', 'building_name' => 'Student Center', 'floor_no' => 'Ground floor', 'room_no' => null],
        ])->map(fn ($location) => Location::firstOrCreate($location));

        $wifiComplaint = Complaint::firstOrCreate(
            ['complaint_no' => 'FMC-DEMO-001'],
            [
                'student_id' => $student->id,
                'category_id' => $categories['Wi-Fi']->id,
                'location_id' => $locations->first()->id,
                'current_staff_id' => $staff->id,
                'title' => 'Wi-Fi drops during lab classes',
                'description' => 'The internet connection drops repeatedly during scheduled programming lab classes and interrupts submissions.',
                'priority' => 'high',
                'status' => 'in_progress',
                'submitted_at' => now()->subDays(2),
            ]
        );

        ComplaintStatusLog::firstOrCreate(
            ['complaint_id' => $wifiComplaint->id, 'new_status' => 'in_progress'],
            [
                'changed_by' => $admin->id,
                'old_status' => 'assigned',
                'remarks' => 'Assigned staff has started checking the access point.',
                'created_at' => now()->subDay(),
            ]
        );

        Complaint::firstOrCreate(
            ['complaint_no' => 'FMC-DEMO-002'],
            [
                'student_id' => $student->id,
                'category_id' => $categories['Cleaning']->id,
                'location_id' => $locations->last()->id,
                'title' => 'Wash area needs cleaning',
                'description' => 'The cafeteria wash area needs urgent cleaning after lunch hours and bins need to be cleared.',
                'priority' => 'medium',
                'status' => 'pending',
                'submitted_at' => now()->subHours(8),
            ]
        );
    }
}
