# Build a Simple CMS Application API with AI-Powered Features
## _Develop a CMS API using PHP (Laravel) and MySQL_
This project is a Content Management System (CMS) API built using Laravel and MySQL, enhanced with AI-powered features such as automated slug generation and article summarization. The application provides robust user authentication, role-based access control, and comprehensive content management capabilities.

## 🔑 Getting Started with OpenRoute - LLM Integration

### 🧠 OpenRoute LLM Integration Guide

**OpenRoute** is a free API integration platform for accessing powerful LLMs, such as `deepseek/deepseek-r1:free`. Follow the steps below to get your API key and start using the model.

---

## 🚀 Getting Started

### 1. Sign In

- Go to [OpenRoute](https://openrouter.ai)
- Click on **"Sign In"** in the top-right corner
- Log in using your **email address**, **Google**, or **GitHub** account

---

### 2. Get Your API Key

- Once logged in, open your **Dashboard**
- Go to the **API Keys** section
- Click **"Create new key"** or **"Generate API Key"**
- **Copy** and **store your API key** securely
- Paste in .env file on OPEN_ROUTER_SECRET=API_KEY  

> ⚠️ Never share your API key publicly

---

### 3. Select the Model

- Navigate to the [Models Page](https://openrouter.ai/models)
- Search for `deepseek/deepseek-r1:free`
- Click on the model name to open its page
- If prompted, click **"Accept Terms"** to enable access

---

### 4. Start Using the API

You’re now ready to integrate the model with your application! Use your API key and selected model to make requests via OpenRoute.

---

## 📘 Example

Here's a basic curl example using the OpenRoute API:

```bash
curl https://openrouter.ai/api/v1/chat/completions \
  -H "Authorization: Bearer YOUR_API_KEY" \
  -H "Content-Type: application/json" \
  -d '{
    "model": "deepseek/deepseek-r1:free",
    "messages": [{"role": "user", "content": "Hello, how are you?"}]
  }
```


## Features

- User Authentication
- Login API
- Seeder for Admin and Author Users (Predefined users for Admin and Author roles via database seeders)
- Content Management
- CRUD for Articles
- AI-Powered Features
- **Slug Generation** ( Automatically generate a unique slug using an LLM based on the title and content. This process runs asynchronously. )
- **Article Summary** ( Automatically create a 2–3 sentence summary using an LLM. Also asynchronously generated.)
- Category Management **(Admin Only)**
- Article Listing & Filtering **(Admin Only)**
- /articles?category_id=1&status=Published&start_date=2025-01-01&end_date=2025-05-20
- **Role-Based Access Control** 
- **Admin** (Manage all articles and categories.)
- **Author** (Manage only their own articles.)

## Installation

CMS requires [Laravel 10](https://laravel.com/docs/10.x/installation) 10.x to run.
Sign in to [OpenRoute](https://openrouter.ai/) for using LLM and generate token.

```sh
cd cms-api-powered
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
QUEUE_CONNECTION=sync to QUEUE_CONNECTION=database **( for runs process asynchronously ).

php artisan work:queue

```

For postman environments...

```sh
base_url = http://127.0.0.1:8000/api
token=Bearer 1|xrbrABEtxm1mMyMf1YM6P0hQpocrs5bsy1jJZAixc482ff18
```

## Plugins

Dillinger is currently extended with the following plugins.
Instructions on how to use them in your own application are linked below.

| Plugin | README |
| ------ | ------ |
| OpenRoute | [https://openrouter.ai/] |

Verify the deployment by navigating to your server address in
your preferred browser.

```sh
127.0.0.1:8000/api
```

## License

MIT
