# LoanZaar Lite - Lead Capture & CRM Platform

A comprehensive PaisaBazaar/BankBazaar-style lead generation and CRM platform built with Laravel 12, Livewire 4, and Filament 5.

## Features

### 🎯 Core Capabilities

- **Dynamic Form Builder** - Create unlimited forms with custom fields through admin panel
- **Lead Management** - Complete CRM with status tracking, assignment, and notes
- **User Dashboard** - Users can track their application status
- **Landing Pages** - SEO-friendly pages with dynamic sections
- **Role-Based Access** - Admin, Agent, and User roles with proper permissions
- **Audit Trail** - Complete history of status changes

### 🔐 Authentication & Authorization

- Three-tier role system: Admin, Agent, User
- Laravel Fortify for authentication
- Policy-based authorization
- Admin panel access control via Filament

### 📋 Dynamic Forms

Forms support the following field types:
- Text, Email, Number, Phone, URL
- Textarea
- Select (dropdown)
- Radio buttons
- Checkboxes
- Date picker
- File upload

Each field can have:
- Custom validation rules
- Placeholder text
- Help text
- Required/optional flag
- Custom ordering

### 📊 CRM Features

**Lead Statuses:**
- New
- Contacted
- In Review
- Approved
- Rejected

**Lead Management:**
- Assign leads to agents
- Add internal notes
- View all submitted field values
- Track complete status history
- Filter and search capabilities

### 🎨 Landing Pages

Dynamic page sections:
- Hero - Main banner with title and description
- Benefits - Feature cards (3-column grid)
- Features - Detailed features with icons
- FAQ - Frequently asked questions
- CTA - Call-to-action button

## Installation

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

### Setup Steps

1. **Clone the repository**
```bash
git clone <repository-url>
cd loanzaar-lite
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup**
```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

5. **Build assets**
```bash
npm run build
```

6. **Start development server**
```bash
php artisan serve
```

## Default Credentials

After seeding, you can login with:

**Admin:**
- Email: admin@example.com
- Password: password

**Agent:**
- Email: agent@example.com
- Password: password

**User:**
- Email: user@example.com
- Password: password

## Usage

### Admin Panel

Access at: `http://localhost:8000/admin`

**Features:**
- Manage forms and fields
- View and manage leads
- Assign leads to agents
- Create landing pages
- Manage users and roles

### Public Pages

**Sample URLs:**
- Landing Page: `http://localhost:8000/pages/personal-loan`
- Form Only: `http://localhost:8000/forms/personal-loan`
- User Dashboard: `http://localhost:8000/my-applications`

### Creating a New Form

1. Login to admin panel
2. Go to Forms → Create
3. Add form details (name, slug, description)
4. Save form
5. Add fields using the "Fields" tab
6. Activate the form

### Creating a Landing Page

1. Login to admin panel
2. Go to Pages → Create
3. Add page details and SEO meta tags
4. Optionally attach a form
5. Add sections (hero, benefits, features, etc.)
6. Publish the page

### Embedding Forms

Forms can be embedded using Livewire component:

```blade
<livewire:dynamic-form slug="personal-loan" />
```

Or accessed directly via URL:
```
/forms/{slug}
```

## Architecture

### Database Schema

**Core Tables:**
- `users` - User accounts with roles
- `forms` - Form definitions
- `form_fields` - Dynamic field configurations
- `leads` - Lead submissions
- `lead_values` - Field values (EAV pattern)
- `lead_status_logs` - Status change audit trail
- `pages` - Landing pages
- `page_sections` - Page content sections

### Key Components

**Livewire Components:**
- `DynamicForm` - Public form submission
- `UserLeads` - User dashboard for viewing applications

**Filament Resources:**
- FormResource - Manage forms and fields
- LeadResource - CRM lead management
- UserResource - User management
- PageResource - CMS page management

**Policies:**
- LeadPolicy - Role-based access control for leads

**Observers:**
- LeadObserver - Automatic status change logging

## API Structure

The platform is designed for future API extension:

**Potential Endpoints:**
- `POST /api/leads` - Submit lead via API
- `GET /api/forms/{slug}` - Get form schema
- `GET /api/pages/{slug}` - Get page data

## Security Features

- CSRF protection
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade templating
- Role-based access control
- Policy-based authorization
- Password hashing with bcrypt
- Input validation on all forms

## Performance Considerations

- Eager loading to prevent N+1 queries
- Database indexing on key columns
- JSON fields for flexible data storage
- Optimized relationships
- Query result caching ready

## Scalability

The platform is designed to scale:

**Current Setup:**
- SQLite for development
- Ready for MySQL/PostgreSQL in production
- Queue system configured (database driver)
- Event-driven architecture with observers

**Future Enhancements:**
- Redis for caching and queues
- Meilisearch for search
- Horizontal scaling support
- API rate limiting
- CDN for static assets

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Livewire 4, Flux UI 2
- **Admin Panel:** Filament 5
- **Authentication:** Laravel Fortify
- **Styling:** Tailwind CSS 4
- **Testing:** Pest 4

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests: `php artisan test`
5. Format code: `vendor/bin/pint`
6. Submit a pull request

## License

MIT License

## Support

For issues and questions, please open an issue on GitHub.

---

Built with ❤️ using Laravel, Livewire, and Filament
