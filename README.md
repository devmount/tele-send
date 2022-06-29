# TeleSend

A simple web app to send data from a web form to a Telegram bot.

## Installation

1. Clone this repository
    ```bash
    git clone https://github.com/devmount/tele-send
    ```
2. Install dependencies
    ```bash
    composer install
    ```
3. Rename example environment file
    ```bash
    mv .env.example .env
    ```
4. Fill in the required bot token and chat id of the chat, the form data should be posted in by the bot.
5. Serve the files by a web server
