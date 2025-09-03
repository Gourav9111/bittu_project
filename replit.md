# Jay Shree Mahakal Finance Services (JSMF) - PHP/MySQL Application

## Overview

This project is a comprehensive finance services website for Jay Shree Mahakal Finance Services (JSMF), built with PHP and MySQL. The platform serves multiple user types including customers applying for loans, DSAs (Direct Selling Agents) managing leads, and administrators overseeing the entire system. The application is designed for deployment on Hostinger shared hosting and includes features for loan applications, EMI calculations, status tracking, and multi-role dashboards.

## User Preferences

Preferred communication style: Simple, everyday language.

## System Architecture

### Frontend Architecture
- **Technology Stack**: Bootstrap CSS framework with custom styling using CSS variables for consistent theming
- **Color Scheme**: Red-themed branding (--primary-red: #dc3545) throughout the application
- **JavaScript**: Vanilla JavaScript with modular approach for different features (EMI calculator, form validations, animations)
- **Responsive Design**: Bootstrap-based responsive layout for mobile and desktop compatibility

### Backend Architecture
- **Language**: PHP for server-side processing
- **Database**: MySQL with dedicated connection configuration
- **Structure**: Multi-directory organization separating public pages, admin functions, DSA portal, and utility pages
- **Authentication**: Role-based access control for customers, DSAs, and administrators

### Data Storage Solutions
- **Primary Database**: MySQL hosted on Hostinger
- **Connection Management**: Centralized database configuration in config.php
- **Data Organization**: Structured for loan applications, user management, DSA assignments, and administrative functions

### Authentication and Authorization Mechanisms
- **Multi-Role System**: Three distinct user types (customers, DSAs, admins)
- **Session Management**: PHP sessions for maintaining user authentication state
- **Access Control**: Directory-based separation (/admin, /dsa) with login protection

### Application Structure
- **Public Pages**: Homepage, loan application, status checking, contact forms
- **EMI Calculator**: Interactive loan calculator with chart visualization
- **DSA Portal**: Registration, login, and lead management dashboard for agents
- **Admin Panel**: Comprehensive dashboard for system administration
- **Static Content**: Terms, conditions, and privacy policy pages

## External Dependencies

### Hosting Platform
- **Provider**: Hostinger shared hosting
- **Domain**: jsmf.in
- **Database Credentials**: Pre-configured MySQL database (u900473099_gourav)

### Frontend Libraries
- **Bootstrap**: CSS framework for responsive design and UI components
- **Chart.js**: Likely used for EMI calculator visualizations and dashboard charts
- **Custom Fonts**: Segoe UI font stack for consistent typography

### Database Configuration
- **Host**: localhost (Hostinger default)
- **Database**: u900473099_gourav
- **User**: u900473099_gourav
- **Credentials**: Stored in config.php for centralized access

### Third-Party Integrations
- **Hosting Infrastructure**: Hostinger shared hosting environment
- **Database Service**: MySQL database service provided by Hostinger
- **Web Server**: Apache/PHP environment typical of shared hosting