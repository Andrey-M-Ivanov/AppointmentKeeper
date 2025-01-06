# Appointment Keeper App

Appointment Keeper is a web application built with Laravel to help users manage and track client appointments. The application offers both a web-based interface and an API for integration with other systems.

---

## Features

- **Appointment Management**: Add, view, update, and delete appointments.
- **Client Integration**: Manage clients' personal details linked to appointments.
- **Search and Filter**: Search appointments by date and partial Universal Control Number (UCN).
- **API Support**: Access and manipulate data.

---

## Installation
- Install PHP dependencies using Composer
- Install front-end dependencies
- Copy the environment configuration file
- Set your database credentials in the .env file
- Run database migrations

---

## API Endpoints
- List Appointments 
	- GET /

- Create Appointment
	- POST /create

	-Body{
  		"name": "John Doe",
 		 "email": "john.doe@example.com",
 		 "phone": "1234567890",
 		 "ucn": "1234567890",
 		 "date": "01-06-2025",
 		 "time": "14:30",
 		 "description": "Consultation",
 		 "notification_type": ["email", "phone"]
		}

