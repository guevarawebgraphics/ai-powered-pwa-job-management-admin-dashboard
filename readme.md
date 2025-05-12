# AI Powered Job Management — Admin Dashboard

This is the **Admin Dashboard** for the Appliance Repair American PWA. Built with Laravel and jQuery, it allows administrators to manage technicians, gigs, user accounts, and more. It also includes real-time chat and a voice assistant (Admin DAX) for hands-free control.

## 🔧 Features

- **Account Management**
  - View, edit, activate/deactivate technician and client accounts
  - Role-based access control

- **Gig & Schedule Management**
  - Create, assign, and manage repair gigs
  - Calendar view of scheduled and completed gigs

- **Technician Management**
  - Approve or reject technician applications
  - Track availability, performance metrics, and job history

- **Real-time Chat**
  - Live messaging with technicians and support staff
  - Message history, read receipts, and notifications

- **Voice Assistant (Admin DAX)**
  - Navigate admin pages via voice commands
  - Query gig statuses, technician assignments, and metrics
  - Document-based Q&A powered by AI

## 🚀 Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: jQuery, Bootstrap 5, Blade templates
- **Voice Assistant**: WebRTC + OpenAI Realtime API
- **Real-time**: Laravel Echo & Pusher
- **Database**: MySQL / MariaDB
- **Auth**: Laravel Sanctum (API) or session-based login

## 📦 Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://your-repo-url/admin-dashboard.git
   cd admin-dashboard
   composer install
   npm install
   npm run dev
   ```

2. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Database setup**

```bash
php artisan migrate --seed
```

4. Run the application
```bash
php artisan serve
```

## 🔒 Authentication & Authorization

Admin login: /admin/login

Protected routes under /admin/*

Policies and middleware enforce role-based permissions


## 🗣️ Voice Commands Examples

“Show today’s gigs”

“Navigate to technician list”

“Approve application for [name]”

“What pending gigs do we have?”

## 📞 Support

If you encounter issues or have questions, contact the development team via the built-in chat or open an issue in this repository.
