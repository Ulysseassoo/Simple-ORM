# ORM PHP

A simple ORM made in pure PHP.

# Config

In order to make this orm work just configure your database credentials in the config.php

You can make this orm work with any entity you create for your project. Here we just used as an exemple Tickets and Comments.

# Different methods

With this ORM, you can:

#### Find All entities

#### Find by id the entities

#### Find by a specific criteria entities

## API Reference

#### Get all tickets

```http
  GET api/tickets
```

#### Get ticket

```http
  GET api/tickets/{id}
```

| Parameter | Type  | Description                       |
| :-------- | :---- | :-------------------------------- |
| `id`      | `int` | **Required**. Id of item to fetch |

#### create a ticket

```http
  POST api/tickets
```

Body : | Parameter | Type | Description | | :-------- | :------- | :-------------------------------- | | `title` | `string` | **Required**. title of ticket| | `section` | `string` | **Required**. section of ticket| | `description` | `string` | **Required**. description of ticket|

#### Export the ticket in a txt file

```http
  GET api/tickets/export/{id}
```

#### Get all comments

```http
  GET api/comments
```

#### Get all comments of a ticket

```http
  GET api/comments/ticket/{ticket_id}
```

| Parameter   | Type  | Description                                |
| :---------- | :---- | :----------------------------------------- |
| `ticket_id` | `Int` | **Required**. ticket Id of ticket to fetch |

#### create a comment for a ticket

```http
  POST api/comments/ticket/{ticket_id}
```

Body : | Parameter | Type | Description | | :-------- | :------- | :-------------------------------- | | `ticket_id` | `Int` | **Required**. id of ticket| | `description` | `string` | **Required**. description of ticket|
