# Event Manager

## How to set up the application
- git clone `https://github.com/olotintemitope/borderlesshr-events.git`
- Run `composer install`
- This application uses docker to setup a consistent running environment
- Download and install docker

### Running Docker
- Clone the application and make sure your docker deamon is running
- On the project root folder, type `docker-compose up -d` and wait for the packages to finish downloading
- Docker installation already comes with PHP 7.2, MySQL 5.7 and other PHP packages

### How to Setup the database
- Open your database client
- Create a new connection and enter the below credentials

```yaml
   Host: 127.0.0.1
   Port: 8002
   User: borderlesshr-events
   Database: events
   Password: secret
```
Click Connect to create a new database connection.

- Import the sample data, so that you can have some data to play around the application.
- Location the database following this directory

```html
 EventManager 
        > database
                 > events.gz
```

### Application URL
- After you've finished importing the database, you can now type
- `127.0.0.1:8000` into your browser

### Admin Login
```yaml
Username: admin@brevents.com
Password: borderlesshr_admin
```

### Sample Attendee Login
```yaml
Username: Laztopaz
Password: test1234
```

### Application Structure
- This  application mimics a typical MVC code architecture


