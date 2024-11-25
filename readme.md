# Telegram Link Shortener Bot  

A simple and efficient Telegram bot that shortens URLs using the Adlinkfly Shortener API. Built with PHP and integrated with Telegram's webhook for seamless URL shortening.

---

## Features  

- **/start Command**: Welcomes users with a message and provides quick links to updates, support, and deployment guides.  
- **Automatic URL Detection**: Identifies URLs in user messages and shortens them.  
- **Multiple URLs**: Handles multiple links in a single message.  
- **Error Notifications**: Alerts users to errors encountered during the shortening process.  
- **Customizable Inline Buttons**: Update links to your updates channel, support group, and GitHub repository easily.  

---

## Requirements  

- A Telegram bot token from [BotFather](https://t.me/BotFather).  
- Your Adlinkfly website account to get an API token.  
- A web server with HTTPS to host the bot script.  

---

## Setup  

1. Setup Webhook
- Open this manually on browser by filling you details in the link
   ```bash
   https://api.telegram.org/bot<YOUR_BOT_TOKEN>/setWebhook?url=https://yourdomain.com/shortner.php
- Replace <BOT_TOKEN> from the terabox.php in line 3, Save file and its done 👍
