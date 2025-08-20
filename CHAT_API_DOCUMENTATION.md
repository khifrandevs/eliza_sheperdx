# Chat API Documentation

This document describes the chat functionality for pendeta (pastors) to communicate with each other via text messages.

## Authentication

All chat endpoints require authentication using JWT token. Include the token in the Authorization header:

```
Authorization: Bearer <your_jwt_token>
```

## Endpoints

### 1. Send Message

**POST** `/api/v1/chat/send`

Send a text message to another pendeta.

**Request Body:**

```json
{
    "receiver_id": 2,
    "message": "Hello, how are you?"
}
```

**Response:**

```json
{
    "success": true,
    "message": "Message sent successfully",
    "data": {
        "id": 1,
        "sender_id": 1,
        "receiver_id": 2,
        "message": "Hello, how are you?",
        "is_read": false,
        "created_at": "2025-08-20T08:45:00.000000Z",
        "updated_at": "2025-08-20T08:45:00.000000Z",
        "sender": {
            "id": 1,
            "nama_pendeta": "John Doe"
        }
    }
}
```

### 2. Get Conversations List

**GET** `/api/v1/chat/conversations`

Get a list of all conversations with other pendetas, including the latest message and unread count.

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "pendeta": {
                "id": 2,
                "nama_pendeta": "Jane Smith"
            },
            "latest_message": {
                "id": 5,
                "message": "See you tomorrow!",
                "created_at": "2025-08-20T10:30:00.000000Z",
                "is_from_me": false
            },
            "unread_count": 2
        }
    ]
}
```

### 3. Get Conversation with Specific Pendeta

**GET** `/api/v1/chat/conversation/{pendetaId}`

Get all messages in a conversation with a specific pendeta. Messages are automatically marked as read when retrieved.

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "sender_id": 1,
            "receiver_id": 2,
            "message": "Hello!",
            "is_read": true,
            "created_at": "2025-08-20T08:00:00.000000Z",
            "updated_at": "2025-08-20T08:00:00.000000Z",
            "sender": {
                "id": 1,
                "nama_pendeta": "John Doe"
            },
            "receiver": {
                "id": 2,
                "nama_pendeta": "Jane Smith"
            }
        }
    ]
}
```

### 4. Get Pendeta List

**GET** `/api/v1/chat/pendeta-list`

Get a list of all pendetas (excluding the current user) for starting new conversations.

**Response:**

```json
{
    "success": true,
    "data": [
        {
            "id": 2,
            "nama_pendeta": "Jane Smith",
            "region": "North Region",
            "departemen": "Youth Ministry"
        },
        {
            "id": 3,
            "nama_pendeta": "Bob Johnson",
            "region": "South Region",
            "departemen": "Children Ministry"
        }
    ]
}
```

### 5. Mark Messages as Read

**POST** `/api/v1/chat/mark-read`

Mark all messages from a specific sender as read.

**Request Body:**

```json
{
    "sender_id": 2
}
```

**Response:**

```json
{
    "success": true,
    "message": "Marked 3 messages as read"
}
```

### 6. Get Unread Message Count

**GET** `/api/v1/chat/unread-count`

Get the total number of unread messages.

**Response:**

```json
{
    "success": true,
    "data": {
        "unread_count": 5
    }
}
```

## Error Responses

### Validation Error (422)

```json
{
    "success": false,
    "message": "Validation error",
    "errors": {
        "receiver_id": ["The receiver id field is required."],
        "message": ["The message field is required."]
    }
}
```

### Not Found Error (404)

```json
{
    "success": false,
    "message": "Invalid pendeta ID",
    "errors": {
        "pendeta_id": ["The selected pendeta id is invalid."]
    }
}
```

### Bad Request Error (400)

```json
{
    "success": false,
    "message": "You cannot send message to yourself"
}
```

## Mobile App Integration

For mobile app integration, you can:

1. **Poll for new messages**: Call `/chat/conversations` periodically to check for new messages
2. **Real-time updates**: Implement WebSocket or Server-Sent Events for real-time messaging
3. **Push notifications**: Send push notifications when new messages arrive
4. **Offline support**: Cache conversations locally and sync when online

## Security Features

-   Messages can only be sent between authenticated pendetas
-   Users cannot send messages to themselves
-   Messages are automatically marked as read when retrieved
-   All endpoints require valid JWT authentication
-   Input validation prevents malicious content
