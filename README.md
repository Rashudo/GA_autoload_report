  # GA_autoload_report
  Connect to mail server, fetch email with .csv file, parse it and export data to db.
  
  - Set up reports in Google Analytics. 
  - Set up automatic mailing to any mailbox.
  - Create file www/.env with this data:
  
  MAIL_SERVER = your_mail_server
  
  MAIL_USER = your_login@your_mail_server.com
  
  MAIL_PASS = email_password
  
  FROM_ADDRESS = Email on Google Analytics
  
  DB_NAME = your db name
  
  DB_HOST = your db host
  
  DB_PORT = 3306
  
  DB_LOGIN = db login
  
  DB_PASS = db pass
  
  - Run this command on your server 
  export DOCKERHOST=$(hostname -I | awk '{print $1}')
  
  - Run Docker-compose
  
  - Create table crm_ga (order_id, channel, adv). 
    Or Use vendor/bin/doctrine orm:schema-tool:update --force on crm_getter_php
  
  - Service available on localhost:8080 port (You can change it in docker-composer.yml)
   