# MPESA Payments Using Laravel 11 and Safaricom Daraja API 2.0

## Prerequisites
1. PHP 8.2 or above
2. MySQL Server/Maria DB, PostgreSQL, or DBMS of your choice
3. Apache 2 Web Server  [Apache Homepage](https://httpd.apache.org/)

> N/B: Installing and setting up the above packages may be tricky, especially for Windows and Mac Users. For Windows users, WAMP is recommended [WAMP Download](https://www.wampserver.com/en/). For Mac users, MAMP is recommended [MAMP Download](https://www.mamp.info/en/downloads/). Ignore the packages above and install one of these stacks instead. Only install the three packages above manually if you know what you are doing.

4. PHP Composer [Composer Homepage](https://getcomposer.org/)
5. Node.js 18 or higher (for Vite, and LocalTunnel) [Node.js Homepage](https://nodejs.org/en)
6. PHP added to PATH. (Research on how to add PHP to PATH on your Operaing System)
7. Composer added to PATH
8. Local Tunnel [Visit Localtunnel Homepage](https://theboroer.github.io/localtunnel-www/) or NGROK [Visit NGROK Homepage](https://ngrok.com/) to tunnel localhost.

## How to Run
1. Clone this repo and copy the folder to your `www` or `htdocs` folder depending on your Operating System.
2. Open the folder in your favorite text editor. [Visual Studio Code](https://code.visualstudio.com/) is highly recommended.
3. Rename `.env.example` to `.env`
4. Edit `.env` and fill in the required properties and save the file. The required properties are explained in the next section. 
5. Open terminal and run `php artisan migrate` to migrate the tables.
6. Open a separate terminal window and start `LocalTunnel` or `NGROK` to tunnel localhost.
7. Navigate to the URL provided by `LocalTunnel` or `NGROK` and append the folder name. e.g `https://localtunnel.abc/{YOUR FOLDER}`
8. Test your application by filling in the form.
9. Enjoy!

## Required .env Properties
- `DB_CONNECTION` - Database driver. Possible values `mysql`, `pgsql`, `sqlite`, `sql`
- `DB_HOST` - Database host. Default `localhost`
- `DB_PORT` - Database Port. Default `3306`
- `DB_DATABASE` - Database to use. Should already be created in DBMS.
- `DB_USERNAME` - Database user
- `DB_PASSWORD` - Database user password. Leave blank if user does not have a database
- `MPESA_SHORTCODE` - Mpesa Stortcode (Paybill Number or Till Number). Use `1` or `174379` for testing purposes.
- `MPESA_CONSUMER_KEY` - Mpesa Consumer Key. Get it from [Safaricom Daraja API 2.0 Website](https://developer.safaricom.co.ke/)
- `MPESA_CONSUMER_SECRET` - Mpesa Consumer Secret. Get it from [Safaricom Daraja API 2.0 Website](https://developer.safaricom.co.ke/)
- `MPESA_PASSKEY` - Mpesa Passkey. Get it from Safaricom once your App goes Live. Use `bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919` for testing purposes.
- `MPESA_TRANSACTION_TYPE` - Mpesa Transaction Type. Only two values accepted. `paybill` or `till`.
- `MPESA_ENVIRONMENT` - Mpesa environment. Only two values accepted. `sandbox` or `live`. Use `sandbox` while testing with MPESA Sandbox Apps and `live` when your app goes live.

## MPESA Sandbox Test Credentials
1. MPESA Passkey - `bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919`
2. MPESA Shortcode - `1` or `174379`

## Credits
1. Laravel by Taylor Otwell [Visit Laravel Website](https://laravel.com/)
2. MPESA Daraja API 2.0 vy Safaricom [Visit Safaricom Daraja API 2.0 Website](https://developer.safaricom.co.ke/)
3. Tailwind CSS by Adam Wathan [Visit Tailwind CSS Website](https://tailwindcss.com/)