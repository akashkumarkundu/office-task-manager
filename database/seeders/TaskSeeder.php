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
                'is_pinned' => true,
                'title' => 'Update Company Website Landing Page',
                'description' => 'Redesign hero section with new product screenshots, dark mode preview, and customer testimonials banner.',
                'assigned_to' => 'Emon Ahmed',
                'category' => 'Frontend',
                'tags' => 'UI/UX, SaaS, HighPriority',
                'priority' => 'Urgent',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(2)->format('Y-m-d'), // Due Soon
                'estimated_hours' => 16,
                'spent_hours' => 9.5,
            ],
            [
                'is_pinned' => true,
                'title' => 'Prepare Monthly Financial Statement Q3',
                'description' => 'Audit incoming invoices, operational expenses, and compile profit & loss report for management review.',
                'assigned_to' => 'Tanvir Hasan',
                'category' => 'Finance',
                'tags' => 'Audit, Q3, Executive',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => Carbon::today()->subDays(2)->format('Y-m-d'), // OVERDUE
                'estimated_hours' => 16,
                'spent_hours' => 4.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Configure Production Server Firewall & SSL',
                'description' => 'Renew wildcard SSL certificates and inspect Nginx rate limiting rules.',
                'assigned_to' => 'Rakib Chowdhury',
                'category' => 'Security',
                'tags' => 'DevOps, SSL, Security',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(4)->format('Y-m-d'),
                'estimated_hours' => 8,
                'spent_hours' => 8.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Design Mobile App Figma Mockups',
                'description' => 'Draft high-fidelity UI wireframes and user flow for task tracking mobile client.',
                'assigned_to' => 'Sarah Jenkins',
                'category' => 'UI/UX',
                'tags' => 'Figma, Mobile, Design',
                'priority' => 'Medium',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(5)->format('Y-m-d'),
                'estimated_hours' => 24,
                'spent_hours' => 14.5,
            ],
            [
                'is_pinned' => false,
                'title' => 'Client Feedback Survey Analysis',
                'description' => 'Aggregate satisfaction scores and extract qualitative feature requests from quarterly customer interviews.',
                'assigned_to' => 'Amina Rahman',
                'category' => 'Marketing',
                'tags' => 'Analytics, Research',
                'priority' => 'Low',
                'status' => 'Pending',
                'due_date' => Carbon::today()->addDays(7)->format('Y-m-d'),
                'estimated_hours' => 6,
                'spent_hours' => 1.5,
            ],
            [
                'is_pinned' => true,
                'title' => 'Database Performance Optimization & Indexing',
                'description' => 'Analyze slow query logs, optimize composite indexes on tasks table, and verify response times.',
                'assigned_to' => 'Michael Chang',
                'category' => 'Backend',
                'tags' => 'Database, MySQL, Performance',
                'priority' => 'Urgent',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(1)->format('Y-m-d'), // Due Soon
                'estimated_hours' => 12,
                'spent_hours' => 6.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Weekly Team Sprint Review & Planning',
                'description' => 'Review milestone delivery, update Jira board, and allocate resources for upcoming sprint.',
                'assigned_to' => 'Fatima Begum',
                'category' => 'Management',
                'tags' => 'Sprint, Agile, Planning',
                'priority' => 'Medium',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(1)->format('Y-m-d'),
                'estimated_hours' => 4,
                'spent_hours' => 3.5,
            ],
            [
                'is_pinned' => false,
                'title' => 'Setup CI/CD Pipeline on GitHub Actions',
                'description' => 'Write automated workflow to run PHPUnit test suites and linting on every pull request.',
                'assigned_to' => 'Rakib Chowdhury',
                'category' => 'DevOps',
                'tags' => 'CI/CD, GitHub, Automation',
                'priority' => 'High',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(6)->format('Y-m-d'),
                'estimated_hours' => 10,
                'spent_hours' => 9.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Employee Security Awareness Workshop',
                'description' => 'Conduct 45-minute interactive seminar on phishing defense and 2-Factor Authentication protocols.',
                'assigned_to' => 'David Miller',
                'category' => 'Security',
                'tags' => 'Compliance, Workshop, HR',
                'priority' => 'Medium',
                'status' => 'Pending',
                'due_date' => Carbon::today()->addDays(10)->format('Y-m-d'),
                'estimated_hours' => 6,
                'spent_hours' => 0.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Optimize Office Cloud Storage & Backup Retention',
                'description' => 'Clean up redundant temporary archives, verify AWS S3 lifecycle policies and test restore.',
                'assigned_to' => 'Michael Chang',
                'category' => 'DevOps',
                'tags' => 'AWS, Cloud, Backup',
                'priority' => 'Low',
                'status' => 'Pending',
                'due_date' => Carbon::today()->subDays(5)->format('Y-m-d'), // OVERDUE
                'estimated_hours' => 8,
                'spent_hours' => 2.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Review Legal Contracts & GDPR Compliance Policy',
                'description' => 'Consult legal counsel to renew SLA terms and user privacy policy for international clients.',
                'assigned_to' => 'Tanvir Hasan',
                'category' => 'Legal',
                'tags' => 'GDPR, Legal, Enterprise',
                'priority' => 'High',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(3)->format('Y-m-d'), // Due Soon
                'estimated_hours' => 14,
                'spent_hours' => 8.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Prepare Brand Assets & Pitch Deck for Q4 Investors',
                'description' => 'Refine presentation typography, include quarterly revenue growth charts, and export PDF.',
                'assigned_to' => 'Sarah Jenkins',
                'category' => 'UI/UX',
                'tags' => 'PitchDeck, Design, Executive',
                'priority' => 'Medium',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(6)->format('Y-m-d'),
                'estimated_hours' => 18,
                'spent_hours' => 11.0,
            ],
            [
                'is_pinned' => true,
                'title' => 'Implement 2-Factor Authentication (2FA) API',
                'description' => 'Integrate Time-based One-Time Password (TOTP) algorithm using Google Authenticator standard.',
                'assigned_to' => 'Emon Ahmed',
                'category' => 'Backend',
                'tags' => 'Security, 2FA, API',
                'priority' => 'Urgent',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(1)->format('Y-m-d'), // Due Soon
                'estimated_hours' => 16,
                'spent_hours' => 12.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Integrate SSLCommerz & bKash Merchant Gateway',
                'description' => 'Build secure webhook handler for instant payment notifications and reconciliation.',
                'assigned_to' => 'Tanvir Hasan',
                'category' => 'Backend',
                'tags' => 'Payment, Gateway, FinTech',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => Carbon::today()->subDays(1)->format('Y-m-d'), // OVERDUE
                'estimated_hours' => 20,
                'spent_hours' => 3.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Conduct Stress Test on REST API Endpoints',
                'description' => 'Simulate 5,000 concurrent user requests using Apache JMeter and report latency metrics.',
                'assigned_to' => 'Michael Chang',
                'category' => 'QA Testing',
                'tags' => 'QA, Benchmark, StressTest',
                'priority' => 'Medium',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(2)->format('Y-m-d'),
                'estimated_hours' => 8,
                'spent_hours' => 7.5,
            ],
            [
                'is_pinned' => false,
                'title' => 'Write Technical API Documentation in Swagger / OpenAPI',
                'description' => 'Document all RESTful endpoints, request/response JSON schemas, and authentication headers.',
                'assigned_to' => 'Fatima Begum',
                'category' => 'Frontend',
                'tags' => 'Docs, Swagger, API',
                'priority' => 'Low',
                'status' => 'Pending',
                'due_date' => Carbon::today()->addDays(8)->format('Y-m-d'),
                'estimated_hours' => 12,
                'spent_hours' => 0.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Design & Code Email Newsletter HTML Template',
                'description' => 'Build responsive, bulletproof HTML email compatible with Outlook, Gmail, and Apple Mail.',
                'assigned_to' => 'Amina Rahman',
                'category' => 'Marketing',
                'tags' => 'Email, Template, Marketing',
                'priority' => 'Low',
                'status' => 'Completed',
                'due_date' => Carbon::today()->subDays(6)->format('Y-m-d'),
                'estimated_hours' => 6,
                'spent_hours' => 5.5,
            ],
            [
                'is_pinned' => false,
                'title' => 'Kubernetes Cluster Health & Autoscaling Setup',
                'description' => 'Configure Horizontal Pod Autoscalers (HPA) and inspect node memory limits under load spikes.',
                'assigned_to' => 'Rakib Chowdhury',
                'category' => 'DevOps',
                'tags' => 'K8s, DevOps, Infra',
                'priority' => 'High',
                'status' => 'Pending',
                'due_date' => Carbon::today()->subDays(3)->format('Y-m-d'), // OVERDUE
                'estimated_hours' => 16,
                'spent_hours' => 2.0,
            ],
            [
                'is_pinned' => false,
                'title' => 'Conduct Employee Performance Review Q3',
                'description' => 'Schedule 1-on-1 feedback sessions, review KPI achievements, and align Q4 development goals.',
                'assigned_to' => 'Sarah Jenkins',
                'category' => 'Management',
                'tags' => 'HR, Review, KPI',
                'priority' => 'Medium',
                'status' => 'In Progress',
                'due_date' => Carbon::today()->addDays(5)->format('Y-m-d'),
                'estimated_hours' => 8,
                'spent_hours' => 4.5,
            ],
        ];

        foreach ($sampleTasks as $index => $taskData) {
            $task = Task::create($taskData);

            // Subtasks & Comments distribution
            if ($index === 0) {
                $task->subtasks()->createMany([
                    ['title' => 'Draft modern hero layout in Tailwind/Bootstrap', 'is_completed' => true],
                    ['title' => 'Integrate customer testimonials slider', 'is_completed' => true],
                    ['title' => 'Review mobile responsiveness on iOS & Android', 'is_completed' => true],
                    ['title' => 'Publish to production server', 'is_completed' => false],
                ]);

                $task->comments()->createMany([
                    ['user_name' => 'Emon Ahmed', 'comment' => 'Completed the hero banner redesign and dark mode theme engine.'],
                    ['user_name' => 'Sarah Jenkins', 'comment' => 'Looks super clean! The obsidian and emerald palettes are gorgeous.'],
                ]);
            } elseif ($index === 1) {
                $task->subtasks()->createMany([
                    ['title' => 'Gather vendor invoices from finance inbox', 'is_completed' => true],
                    ['title' => 'Calculate operational expenses & depreciation', 'is_completed' => false],
                    ['title' => 'Export final summary spreadsheet', 'is_completed' => false],
                ]);
            } elseif ($index === 5) {
                $task->subtasks()->createMany([
                    ['title' => 'Inspect slow query logs for table joins', 'is_completed' => true],
                    ['title' => 'Add composite index on status and due_date', 'is_completed' => true],
                    ['title' => 'Benchmark query execution time under 10k rows', 'is_completed' => false],
                ]);

                $task->comments()->createMany([
                    ['user_name' => 'Michael Chang', 'comment' => 'Index added, query latency dropped from 120ms to 4ms!'],
                ]);
            } elseif ($index === 12) {
                $task->subtasks()->createMany([
                    ['title' => 'Setup Google Authenticator QR Code generator', 'is_completed' => true],
                    ['title' => 'Implement emergency backup recovery codes', 'is_completed' => true],
                    ['title' => 'Test rate limiting for brute-force OTP attempts', 'is_completed' => false],
                ]);

                $task->comments()->createMany([
                    ['user_name' => 'Emon Ahmed', 'comment' => 'QR code generation is completed and working with Google Authenticator app.'],
                ]);
            } elseif ($index === 13) {
                $task->subtasks()->createMany([
                    ['title' => 'Setup SSLCommerz sandbox credentials', 'is_completed' => true],
                    ['title' => 'Implement IPN (Instant Payment Notification) listener', 'is_completed' => false],
                    ['title' => 'Test refund and dispute webhook payloads', 'is_completed' => false],
                ]);
            }
        }
    }
}
