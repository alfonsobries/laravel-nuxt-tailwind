# Laravel-Nuxt API

A Laravel-Nuxt styled with TailwindCSS starter project template.

Inspired in `cretueusebiu/laravel-nuxt`


<p align="center">
<img src="https://i.imgur.com/TGP7Iiu.png">
</p>

## Features

- Laravel 6
- Authentication with JWT
- Nuxt 2.10
- TailwindCSS
- VueTailwind Components
- VueI18n
- SSR or SPA 
- Authentication with JWT
- Socialite integration
- Login, register, password reset and profile pages

## Installation

- `git clone git@github.com:alfonsobries/laravel-nuxt-tailwind.git <name-of-your-project>`
- Edit `.env` to set your database connection details
- Install dependencies `composer update` and `npm install` (or `yarn install`)
- run `php artisan key:generate` and `php artisan jwt:secret`
- `php artisan migrate`


## Usage

### Development

```bash
npm run dev
```

### Production with SSR

```bash
npm run build
npm run start
```

#### Nginx Proxy

For Nginx you can add a proxy using the follwing location block:

```
server {
    location / {
        proxy_pass http://HOST:PORT;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }
}
```

Where `HOST` is the ip address of your server and `PORT` is the port you're running the application (3000 by default).

#### Process Manager

In production you need a process manager to keep the Node server alive forever:

```bash
# install pm2 process manager
npm install -g pm2

# startup script
pm2 startup

# start process
pm2 start npm --name "laravel-nuxt" -- run start

# save process list
pm2 save

# list all processes
pm2 l
```

After each deploy you'll need to restart the process:

```bash
pm2 restart laravel-nuxt 
```

### Production without SSR

If you don't want server side rendering you can use the [mode](https://nuxtjs.org/api/configuration-mode#the-mode-property) option:

- Uncomment `mode: 'spa'` and `'~plugins/nuxt-client-init'` in `client/nuxt.config.js` 
- Uncomment `// ->prefix('api')` in `app/Providers/RouteServiceProvider.php` 
- Set `APP_URL=http://example.com/api` and `CLIENT_URL=http://example.com` in your `.env`
- Run `npm run build`

Make sure to read the [Nuxt docs](https://nuxtjs.org/).

## Notes

- This project uses [router-module](https://github.com/nuxt-community/router-module), so you have to add the routes manually in `client/router.js`.
- If you want to separate this in two projects (client and server api), move `package.json` into `client/` and remove config path option from the scripts section. Also make sure to add the env variables in `client/.env`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.
