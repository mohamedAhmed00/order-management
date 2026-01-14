# Order & Payment Management API

This repository contains a Laravel-based RESTful API for managing **Orders** and **Payments**, designed with extensibility, clean architecture, and real-world business rules in mind.

The project was implemented as part of a technical assessment and focuses on maintainability, clarity, and scalability rather than UI concerns.

---

## Project Overview

### Core Features
- JWT-based authentication (Register / Login)
- Order management (create, update, view, cancel)
- Payment processing with multiple gateways
- Strict business rule enforcement
- Clean and extensible architecture
- Comprehensive API documentation using Postman

---

## Tech Stack
- Laravel (API-focused)
- JWT Authentication
- MySQL
- Postman (API Documentation)

---

## Setup Instructions

### 1 Clone the Repository
```bash
git clone git@github.com:mohamedAhmed00/order-management.git
cd order-management
```

### 2 Install Dependencies
```bash
composer install
```

### 3 Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Update the following in `.env`:
```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

JWT_SECRET=your_jwt_secret
```

Generate JWT secret:
```bash
php artisan jwt:secret
```

### 4 Run Migrations
```bash
php artisan migrate
```

### 5 Start the Server
```bash
php artisan serve
```

---

## Authentication

- Authentication is implemented using **JWT (JSON Web Tokens)**.
- Users can register and login to receive a token.
- All protected endpoints require a valid Bearer token.

Example header:
```
Authorization: Bearer {token}
```

---

## Orders Management

### Features
- Create orders with purchased items (name, quantity, price)
- Automatically calculate total order amount
- View all orders with pagination
- Filter orders by status (`pending`, `confirmed`, `cancelled`)
- View a single order with its associated payments
- Update order details
- Cancel orders (logical deletion)

## **Order Cancellation**
Orders are **not physically deleted** from the database.

Calling the delete endpoint will:
- Update the order status to `cancelled`
- Preserve historical data for auditing and reporting

Orders with associated payments **cannot be cancelled**.

---

## Payments Management

### Features
- Payments can only be processed for orders with status `confirmed`
- Payment statuses:
    - `pending`
    - `successful`
    - `failed`
- View all payments with pagination
- View payments related to a specific order

---

## Payment Gateway Extensibility

Payment processing follows the **Strategy Pattern** to ensure easy extensibility.

### Design
- `PaymentGatewayInterface`
- Individual gateway implementations (e.g., Credit Card, PayPal)
- `PaymentGatewayFactory` responsible for resolving the correct gateway

### Adding a New Payment Gateway
1. Create a new gateway class implementing `PaymentGatewayInterface`
2. Register the gateway in the factory or configuration
3. No changes are required in the payment business logic

This design ensures minimal code changes when adding new payment methods.

---

## Validation & Error Handling

### Validation
- All API inputs are validated using Laravel Form Request classes
- Nested product validation is enforced only when products are provided

### Error Handling
- Business rule violations throw domain-level exceptions
- Exceptions are mapped to appropriate HTTP status codes:
    - `422 Unprocessable Entity` for business rule violations
    - `401 Unauthorized` for authentication errors

---

## Pagination
Pagination is implemented for:
- Orders listing
- Payments listing

Standard Laravel pagination format is used.

---

## API Documentation (Postman)

API documentation is provided using **Postman**.

### Documentation Includes
- Organized endpoints by functionality:
    - Authentication
    - Orders
    - Payments
- Detailed examples of:
    - Successful responses
    - Validation errors
    - Business rule errors
- JWT Bearer token configuration
- Pagination examples

 A Postman collection export file is included in the repository for easy import and testing.

 In the root directory locate the `Order Management API.postman_collection.json` file. Import it into Postman to view the documentation.

---

## Testing

The application is designed to be easily testable:
- Business logic is isolated in service classes
- Payment gateway logic is abstracted via interfaces
- Gateways can be tested independently using mocks

This structure allows straightforward implementation of unit and integration tests, especially for payment processing scenarios.

---

## Assumptions & Notes

- Orders are cancelled logically rather than physically deleted
- Payment gateways are simulated, but the architecture supports real integrations
- The focus of this implementation is backend logic and API design.
- Products are not modeled as a separate entity, as the task focuses on order creation with purchased products snapshots (name, quantity, price) at the time of checkout.
- The repository design pattern was intentionally omitted to avoid over-engineering, as the project scope is simple. The code is structured in a way that allows introducing repositories later if needed.
---

## Summary

This project demonstrates:
- Proper RESTful API design
- Clean and maintainable code
- Strong separation of concerns
- Extensible payment processing architecture
- Clear and complete documentation

The solution is production-oriented and designed to scale with future business requirements.



