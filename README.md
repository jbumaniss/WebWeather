# WeatherReport App

The WeatherReport App is a comprehensive tool for obtaining past and current weather information in a specified location. It is developed using PHP, Twig, Guzzle, and Carbon.

## Features

- Fetch past and current day weather data for any location entered in the search bar.
- User-friendly interface for easy navigation and data presentation.

## Application Preview

### Weather Report Interface
<img src="whetherReport.gif" alt="Weather Report GIF" width="500"/>

### Detailed Weather View
<img src="whetherReport2.png" alt="Detailed Weather Screenshot" width="500"/>

## Setup Instructions

### Prerequisites

- PHP installed on your machine.
- Registered API key from [WeatherAPI](https://www.weatherapi.com/).

### Installation Process

1. **API Key Registration**: 
   Register for an API key at [WeatherAPI](https://www.weatherapi.com/).

2. **Clone Repository**: 
   Clone or download this repository to your desired directory.

3. **Environment File Setup**: 
   Rename `.env.example` to `.env` in the root directory.

4. **Configure API Key**: 
   Add your WeatherAPI key to the `.env` file.

5. **Install Dependencies**: 
   Run the following command to install required packages:
composer install

6. **Launch Server**: 
Start the application using:
php -S localhost:8080

## Using the App

After installation, open `localhost:8080` in your web browser to access the WeatherReport App. Enter the desired location in the search bar to view past and current weather information.

---

**Note**: This application is intended for demonstration and educational purposes and is not recommended for production use without further modifications.
