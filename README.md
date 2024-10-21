# Cryptocurrency Price Tracker

This is a Laravel-based cryptocurrency price tracking system that allows users to fetch the latest prices and historical data for various cryptocurrencies using the CoinGecko API.

## Note on Docker Setup
For a proper production setup, it is recommended to run the application and database in two separate containers. However, due to limitations faced with the chosen hosting service, everything has been run in a single container for deployment purposes.

## Features

- Retrieve the latest price of a specified cryptocurrency.
- Fetch historical prices for a specified cryptocurrency on a given date.
- Store price data in a MySQL database for persistence.
- Validate user input for supported cryptocurrencies and date formats.

## Technologies Used

- PHP
- Laravel
- MySQL
- Composer
- CoinGecko API
- Docker

## Installation

### Prerequisites

- Docker
- Docker Compose

### Clone the Repository

```bash
git clone https://github.com/silvathiagodeveloper/wealth99
cd wealth99
```

### Docker Setup

1. **Build and start the Docker containers:**

```bash
   docker-compose up -d
```

### Accessing the Application

1. Open your web browser and go to [http://localhost:8000](http://localhost:8000).

## API Endpoints

### Get Latest Price

**Endpoint:** `/prices/latest`

**Method:** `GET`

**Query Parameters:**

- `coin`: The cryptocurrency ID (e.g., `bitcoin`, `ethereum`).

**Example Request:**

```bash
GET http://localhost:8000/prices/latest?coin=bitcoin
```

**Response:**

```json
{
  "coin": "bitcoin",
  "price": 50000
}
```

### Get Historical Price

**Endpoint:** `/prices/historical`

**Method:** `GET`

**Query Parameters:**

- `coin`: The cryptocurrency ID (e.g., `bitcoin`, `ethereum`).
- `datetime`: The date and time in the format Y-m-d H:i:s.

**Example Request:**

```bash
GET http://localhost:8000/prices/historical?coin=bitcoin&datetime=2024-10-21 12:00:00
```
**Response:**

```json
{
  "coin": "bitcoin",
  "price": 48000,
  "datetime": "2024-10-21 12:00:00"
}
```

## Running Tests
To run the test suite, use:

```bash
docker-compose exec app php artisan test
Stopping the Application
```

To stop the Docker containers, run:

```bash
docker-compose down
```