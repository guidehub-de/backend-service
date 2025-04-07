# GuideHub Backend Service

This repository contains the backend service for **GuideHub**, developed in PHP using the **Symfony** framework.
Deployed in a Docker container, the service provides a RESTful API for seamless integration.

## 🌍 About GuideHub

GuideHub is a platform designed for **tour guides**, **agencies**, **museums**, and **associations** to coordinate
tours, lectures, and other events.

- Invite guides via email and collaborate on tours.
- Create and manage programs (e.g., city tours, museum visits).
- Assign suitable guides and organize schedules with ease.

🔗 [guidehub.de](https://guidehub.de/)

Created by Anton Dachauer ([var-lab IT GmbH](https://var-lab.com)).

---

## 🚀 Planned Features

- Guide & program management
- Efficient booking coordination
- Built-in scheduling workflows

---

## 🛠️ Getting started as developer

To set up the backend service locally:

### 1. Clone the repository

```bash
git clone https://github.com/guidehub-de/guidehub.git
```

### 2. Navigate to the project folder

```bash
cd guidehub
```

### 3. Install dependencies

```bash
composer install
```

### 5. (Re-) Create the database

```bash
composer run db:recreate:dev
```

### 6. Start the development server

```bash
docker compose up -d
```

## Local hosts for development

| Host                   | Description            |
|------------------------|------------------------|
| guidehub-api.localhost | Backend API & API Docs |
| mails.localhost        | Mailpit UI             |

# 🤝 Contribute

We welcome contributions! To contribute:

1. Fork this repository.
2. Create a feature branch.
3. Submit a pull request.


