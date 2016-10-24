# User API
#
## Run Docker
```sh
$ cd user-api
$ sudo docker-compose up
```

## API

### Get all users:
> GET /api/users/

### Get a single user:
> GET /api/users/:userid
>
Parameters:
- userid: integer

### Create a user:
> POST /api/users/
>
Parameters:
- name: string
- picture: image
- address: string

### Update a user:
> PUT /api/users/:userid
>
Parameters:
- userid: integer
- name: string
- picture: image
- address: string

### Delete a user:
> DELETE /api/users/:userid
>
Parameters
- userid: integer

## API URL:
127.0.0.1:8080

## PHP MY ADMIN:
127.0.0.1:8181
