# Secure Sensor Dashboard

A containerized IoT sensor monitoring dashboard built with a **LEMP stack** (Linux containers, Nginx, MySQL, PHP). It simulates real‑time environmental data, providing interactive historical charts with a custom scrollbar, and includes secure database interactions and PDF report generation.

![Secure Sensor Dashboard – Real-time temperature and humidity monitoring with scrollable history](https://i.imgur.com/yUpQ6C2.png)

**For end users**, the dashboard is a standard web application. No installation is required—simply visit the hosted URL in any modern web browser.

- **Access the dashboard:** `http://localhost:8080` (if running locally) or the deployed server address.
- **User Requirements:** A web browser (Chrome, Firefox, Edge, Safari) with JavaScript enabled.

*The following sections are for developers/administrators who wish to deploy or modify the application.*

---

## Features

- **Live Data Generation** – Click a button to simulate a new sensor reading (temperature 0–100°C, humidity 0–100%).
- **Interactive Charts** – Pan through historical data using a horizontal scrollbar below the charts (default view: last 50 readings).
- **Time‑Based Search** – Find the closest sensor reading to a specific date and time.
- **PDF Export** – Select a date range and download a formatted PDF report of all readings within that period.

## Security Features

- **SQL Injection Prevention** – All database queries use PDO prepared statements.
- **Nginx Security Headers** – CSP, X‑Frame‑Options, X‑Content‑Type‑Options.
- **Container Isolation** – Application runs in isolated Docker containers.

## Technologies

| Area          | Technologies |
|---------------|--------------|
| **Frontend**  | HTML5, CSS3, JavaScript, Chart.js |
| **Backend**   | PHP 8.1, PDO, MySQL 8.0 |
| **Web Server**| Nginx (Alpine Linux) |
| **PDF**       | Dompdf 3.1 |
| **DevOps**    | Docker, Docker Compose (Linux containers) |
| **Development Host** | Windows (runs Linux containers via Docker) |

## Deployment / Self‑Hosting (For Administrators)

### Prerequisites (Only for the person hosting the application)
- Docker Desktop (Windows / Mac) or Docker Engine (Linux)
- Git (to clone the repository)

### Steps to Deploy Locally

1. **Clone the repository**
   ```bash
   git clone https://github.com/Ntandolis431/secure-sensor-dashboard.git
   cd secure-sensor-dashboard
