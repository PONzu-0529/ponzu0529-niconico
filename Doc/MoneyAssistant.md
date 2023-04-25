# MoneyAssistant

## About

- Manage money inflow and outflow.

## Container

```mermaid
C4Context
  Person(user, "User", "")

  Boundary(ponzu, "Ponzu", "") {
    Boundary(client, "Client", "") {
      Container(view, "View", "", "")

      Container(view_model, "ViewModel", "", "")
    }

    Boundary(server, "Server", "") {
      Container(controller, "Controller", "", "")

      Container(service, "Service", "", "")

      Container(model, "Model", "", "")
    }
  }

  Boundary(db, "DB", "") {
    ContainerDb(db, "db", "", "")
  }

  BiRel(user, view, "", "")
  BiRel(view, view_model, "", "")
  BiRel(view_model, controller, "", "")
  BiRel(controller, service, "", "")
  BiRel(service, model, "", "")
  BiRel(model, db, "", "")
```

## Component

```mermaid
C4Context
  Person(user, "User", "")

  Boundary(view, "View", "") {
    Component(money_assistant_view, "MoneyAssistantView", "", "")
  }

  Boundary(view_model, "ViewModel", "") {
    Component(money_assistant_view_model, "MoneyAssistantViewModel", "", "")
  }

  Boundary(controller, "Controller", "") {
    Component(money_assistant_controller, "MoneyAssistantController", "", "")
  }

  Boundary(service, "Service", "") {
    Component(money_assistant_service, "MoneyAssistantService", "", "")
  }

  Boundary(model, "Model", "") {
    Component(model-expense, "Expense", "", "")
  }

  Boundary(db, "DB", "") {
    ComponentDb(db-expenses, "expenses", "", "")
  }

  BiRel(user, money_assistant_view, "", "")
  BiRel(money_assistant_view, money_assistant_view_model, "", "")
  BiRel(money_assistant_view_model, money_assistant_controller, "", "")
  BiRel(money_assistant_controller, money_assistant_service, "", "")
  BiRel(money_assistant_service, model-expense, "", "")
  BiRel(model-expense, db-expenses, "", "")
```

## Class

```mermaid
classDiagram
  class MoneyAssistantController {
    +index(): Response
    +show(id: int): Response
    +store(request: Request): Response
    +update(id: int, request, Request): Response
    +destroy(id: int): Response
  }

  class MoneyAssistantService {
    +getAll(): array
    +getById(id: int): Expense
    +add(): int
    +update(): void
    +delete(): void
  }

  class Expense

  MoneyAssistantController --> MoneyAssistantService
  MoneyAssistantService --> Expense
```

## ER Diagram

```mermaid
erDiagram
  users

  expenses {
    bigint id PK
    bigint user_id
    varchar title
    int money
    date date
    varchar from
    varchar to
    varchar memo
    timestamp created_at
    timestamp updated_at
    timestamp deleted_at
  }

  users ||--o{ expenses : ""
```
