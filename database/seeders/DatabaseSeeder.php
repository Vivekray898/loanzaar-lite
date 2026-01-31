<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Create agent user
        User::factory()->create([
            'name' => 'Agent User',
            'email' => 'agent@example.com',
            'role' => 'agent',
            'password' => bcrypt('password'),
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
        ]);

        // Create sample form
        $form = \App\Models\Form::create([
            'name' => 'Personal Loan Application',
            'slug' => 'personal-loan',
            'description' => 'Apply for a personal loan with competitive interest rates',
            'is_active' => true,
            'thank_you_message' => '<p>Thank you for your application! Our team will review your submission and get back to you within 24-48 hours.</p>',
        ]);

        // Create form fields
        $fields = [
            [
                'label' => 'Full Name',
                'name' => 'full_name',
                'type' => 'text',
                'is_required' => true,
                'placeholder' => 'Enter your full name',
                'order' => 1,
            ],
            [
                'label' => 'Email Address',
                'name' => 'email',
                'type' => 'email',
                'is_required' => true,
                'placeholder' => 'your.email@example.com',
                'order' => 2,
            ],
            [
                'label' => 'Phone Number',
                'name' => 'phone',
                'type' => 'tel',
                'is_required' => true,
                'placeholder' => '+1 (555) 000-0000',
                'order' => 3,
            ],
            [
                'label' => 'Loan Amount',
                'name' => 'loan_amount',
                'type' => 'number',
                'is_required' => true,
                'placeholder' => 'Enter amount',
                'help_text' => 'Amount in USD',
                'order' => 4,
            ],
            [
                'label' => 'Employment Status',
                'name' => 'employment_status',
                'type' => 'select',
                'is_required' => true,
                'options' => ['Employed', 'Self-Employed', 'Unemployed', 'Student'],
                'order' => 5,
            ],
            [
                'label' => 'Annual Income',
                'name' => 'annual_income',
                'type' => 'number',
                'is_required' => true,
                'placeholder' => 'Annual income in USD',
                'order' => 6,
            ],
            [
                'label' => 'Purpose of Loan',
                'name' => 'loan_purpose',
                'type' => 'textarea',
                'is_required' => true,
                'placeholder' => 'Describe why you need this loan',
                'order' => 7,
            ],
        ];

        foreach ($fields as $fieldData) {
            $form->fields()->create($fieldData);
        }

        // Create sample page
        $page = \App\Models\Page::create([
            'title' => 'Personal Loan',
            'slug' => 'personal-loan',
            'meta_description' => 'Get a personal loan with competitive rates and flexible terms. Apply online in minutes.',
            'meta_keywords' => 'personal loan, quick loan, online loan application',
            'form_id' => $form->id,
            'is_published' => true,
        ]);

        // Create sample sections
        $page->sections()->create([
            'type' => 'hero',
            'title' => 'Quick & Easy Personal Loans',
            'content' => [
                'description' => 'Get the funds you need with our simple and transparent loan process. No hidden fees, competitive rates.',
            ],
            'order' => 1,
        ]);

        $page->sections()->create([
            'type' => 'benefits',
            'title' => 'Why Choose Us',
            'content' => [
                'items' => [
                    ['title' => 'Fast Approval', 'description' => 'Get approved in as little as 24 hours'],
                    ['title' => 'Competitive Rates', 'description' => 'Interest rates starting from 6.99%'],
                    ['title' => 'Flexible Terms', 'description' => 'Choose from 12 to 60 month repayment periods'],
                ],
            ],
            'order' => 2,
        ]);

        $page->sections()->create([
            'type' => 'features',
            'title' => 'Our Features',
            'content' => [
                'features' => [
                    ['title' => 'No Hidden Fees', 'description' => 'Transparent pricing with no surprises'],
                    ['title' => 'Secure Process', 'description' => 'Your data is encrypted and protected'],
                    ['title' => 'Online Application', 'description' => 'Apply from anywhere, anytime'],
                    ['title' => '24/7 Support', 'description' => 'Our team is here to help you'],
                ],
            ],
            'order' => 3,
        ]);

        $page->sections()->create([
            'type' => 'faq',
            'title' => 'Frequently Asked Questions',
            'content' => [
                'questions' => [
                    ['question' => 'How quickly can I get approved?', 'answer' => 'Most applications are reviewed within 24-48 hours.'],
                    ['question' => 'What are the eligibility requirements?', 'answer' => 'You must be 18+ years old, have a steady income, and be a resident of the United States.'],
                    ['question' => 'Can I pay off my loan early?', 'answer' => 'Yes! There are no prepayment penalties.'],
                ],
            ],
            'order' => 4,
        ]);
    }
}
