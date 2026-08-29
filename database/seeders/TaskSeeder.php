<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sampleTasks = [
            [
                'title' => 'Update Company Website Landing Page',
                'description' => 'Redesign hero section with new product screenshots and update customer testimonials banner.',
                'assigned_to' => 'Emon Ahmed',
                'priority' => 'High',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(2)->format('Y-m-d'), // Due Soon
            ],
            [
                'title' => 'Prepare Monthly Financial Statement Q3',
                'description' => 'Audit incoming invoices, operational expenses, and compile profit & loss report for management review.',
                'assigned_to' => 'Tanvir Hasan',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => Carbon::today()->subDays(2)->format('Y-m-d'), // OVERDUE
            ],
            [
                'title' => 'Configure Production Server Firewall & SSL',
                'description' => 'Renew wildcard SSL certificates and inspect Nginx rate limiting rules.',
                'assigned_to' => 'Rakib Chowdhury',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(4)->format('Y-m-d'),
            ],
            [
                'title' => 'Design Mobile App Figma Mockups',
                'description' => 'Draft high-fidelity UI wireframes and user flow for task tracking mobile client.',
                'assigned_to' => 'Sarah Jenkins',
                'priority' => 'Medium',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(5)->format('Y-m-d'),
            ],
            [
                'title' => 'Client Feedback Survey Analysis',
                'description' => 'Aggregate satisfaction scores and extract qualitative feature requests from quarterly customer interviews.',
                'assigned_to' => 'Amina Rahman',
                'priority' => 'Low',
                'status' => 'Pending',
                'due_date' => Carbon::today()->addDays(7)->format('Y-m-d'),
            ],
            [
                'title' => 'Database Performance Optimization & Indexing',
                'description' => 'Analyze slow query logs, optimize composite indexes on tasks table, and verify response times.',
                'assigned_to' => 'Michael Chang',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => Carbon::today()->addDays(1)->format('Y-m-d'), // Due Soon
            ],
            [
                'title' => 'Office Supply Inventory Audit',
                'description' => 'Count hardware supplies, monitor workstation peripherals, and create purchase requisition.',
                'assigned_to' => 'Fatima Begum',
                'priority' => 'Low',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(5)->format('Y-m-d'),
            ],
            [
                'title' => 'Weekly Team Sprint Retrospective',
                'description' => 'Facilitate retrospective meeting, document action items, and plan next sprint backlog.',
                'assigned_to' => 'David Miller',
                'priority' => 'Medium',
                'status' => 'Pending',
                'due_date' => Carbon::today()->subDays(1)->format('Y-m-d'), // OVERDUE
            ],
            [
                'title' => 'API Webhook Integration for Slack Alerts',
                'description' => 'Develop automated notification pipeline for critical task status changes and overdue warnings.',
                'assigned_to' => 'Emon Ahmed',
                'priority' => 'Medium',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(3)->format('Y-m-d'), // Due Soon
            ],
            [
                'title' => 'Security Compliance & Dependency Audit',
                'description' => 'Run composer audit and npm audit, update outdated dependencies, and patch CVE vulnerabilities.',
                'assigned_to' => 'Rakib Chowdhury',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(8)->format('Y-m-d'),
            ],
            [
                'title' => 'Employee Onboarding Checklist Review',
                'description' => 'Refine developer setup guide, software license provisioning, and welcome package.',
                'assigned_to' => 'Amina Rahman',
                'priority' => 'Low',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(6)->format('Y-m-d'),
            ],
            [
                'title' => 'Cloud Backup Verification and Recovery Test',
                'description' => 'Perform routine test restore of database snapshots from AWS S3 to verify data integrity.',
                'assigned_to' => 'Michael Chang',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => Carbon::today()->addDays(4)->format('Y-m-d'),
            ],
        ];

        foreach ($sampleTasks as $index => $taskData) {
            $task = Task::create($taskData);

            // Add sample subtasks for first 4 tasks
            if ($index === 0) {
                $task->subtasks()->createMany([
                    ['title' => 'Draft modern hero layout in Tailwind/Bootstrap', 'is_completed' => true],
                    ['title' => 'Integrate customer testimonials slider', 'is_completed' => true],
                    ['title' => 'Review mobile responsiveness on iOS & Android', 'is_completed' => false],
                    ['title' => 'Publish to production server', 'is_completed' => false],
                ]);

                $task->comments()->createMany([
                    ['user_name' => 'Emon Ahmed', 'comment' => 'Completed the hero banner redesign, working on mobile responsiveness now.'],
                    ['user_name' => 'Sarah Jenkins', 'comment' => 'Looks super clean! Make sure the CTA buttons have proper contrast in dark mode.'],
                ]);
            } elseif ($index === 1) {
                $task->subtasks()->createMany([
                    ['title' => 'Gather vendor invoices from finance inbox', 'is_completed' => true],
                    ['title' => 'Calculate operational expenses & depreciation', 'is_completed' => false],
                    ['title' => 'Export final summary spreadsheet', 'is_completed' => false],
                ]);
            }
        }
    }
}
