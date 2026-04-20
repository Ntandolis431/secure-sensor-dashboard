# Secure Sensor Dashboard

A containerized IoT sensor monitoring dashboard built with a **LEMP stack** (Linux containers, Nginx, MySQL, PHP). It simulates real‑time environmental data, providing interactive historical charts with a custom scrollbar, and includes secure database interactions and PDF report generation.

![Secure Sensor Dashboard – Real-time temperature and humidity monitoring with scrollable history](https://i.imgur.com/yUpQ6C2.png)

**For end users**, the dashboard is a standard web application. No installation is required—simply visit the hosted URL in any modern web browser.

- **Access the dashboard:** http://localhost:8080 (if running locally) or the deployed server address.
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
    + "" + `ash
   git clone https://github.com/Ntandolis431/secure-sensor-dashboard.git
   cd secure-sensor-dashboard
    + "" + `

2. **Start the containers**
    + "" + `ash
   docker-compose up -d
    + "" + `

3. **Install Dompdf (if vendor folder is missing)**
    + "" + `ash
   docker exec -it encata-web sh -c "cd /var/www/html && COMPOSER_PROCESS_TIMEOUT=2000 php composer.phar require dompdf/dompdf"
    + "" + `

4. **Create the database table**
    + "" + `ash
   docker exec -it encata-db mysql -u sensor_user -psensor_pass sensor_data -e "CREATE TABLE IF NOT EXISTS sensor_readings (id INT AUTO_INCREMENT PRIMARY KEY, temperature DECIMAL(5,2) NOT NULL, humidity DECIMAL(5,2) NOT NULL, reading_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP);"
    + "" + `

5. **Access the dashboard**
   Open your browser and go to http://localhost:8080

## Screenshot

![Secure Sensor Dashboard](https://i.imgur.com/yUpQ6C2.png)

## License

This project is created for educational and portfolio purposes. Feel free to use and modify.

---

**Author:** Ntandolis431  
**GitHub:** [Ntandolis431](https://github.com/Ntandolis431)
