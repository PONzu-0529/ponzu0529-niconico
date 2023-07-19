# MylistAssistant

## Container

![](assets/MylistAssistant-Container.svg)


## Component

![](assets/MylistAssistant-Component.svg)

### Get All, Get By Id

```mermaid
C4Context
    Person(user, "User")

    Boundary(client, "Client") {
        Boundary(view, "View") {
            Component(mylist-assistant, "MylistAssistantView")
        }
        Boundary(viewModel, "viewModel") {
            Component(mylist-assistant-view-model, "MylistAssistantViewModel")
        }
    }

    Boundary(server, "Server") {
        Boundary(controller, "Controller") {
            Component(mylist-assistant-controller, "MylistAssistantController")
        }
        Boundary(service, "Service") {
            Component(mylist-assistant-service, "MylistAssistantService")
        }
        Boundary(model, "Model") {
            Component(user-music-view, "UserMusicView")
            Component(model-user_music_2_view, "UserMusic2View")
        }
    }

    Boundary(db, "DB") {
        ComponentDb(user_music_view, "user_music_view")
        ComponentDb(db-user_music_2_view, "user_music_2_view")
    }

    BiRel(user, mylist-assistant, "")
    BiRel(mylist-assistant, mylist-assistant-view-model, "")
    BiRel(mylist-assistant-view-model, mylist-assistant-controller, "")
    BiRel(mylist-assistant-controller, mylist-assistant-service, "")
    BiRel(mylist-assistant-service, model-user_music_2_view, "")
    BiRel(model-user_music_2_view, db-user_music_2_view, "")
```

### Add, Update, Delete

```mermaid
C4Context
    Person(user, "User")

    Boundary(client, "Client") {
        Boundary(view, "View") {
            Component(mylist-assistant, "MylistAssistantView")
        }
        Boundary(viewModel, "viewModel") {
            Component(mylist-assistant-view-model, "MylistAssistantViewModel")
        }
    }

    Boundary(server, "Server") {
        Boundary(controller, "Controller") {
            Component(mylist-assistant-controller, "MylistAssistantController")
        }
        Boundary(service, "Service") {
            Component(mylist-assistant-service, "MylistAssistantService")
        }
        Boundary(model, "Model") {
            Component(music, "Music")
            Component(user-music, "UserMusic")
            Component(model-music_memo, "MusicMemo")
        }
    }

    Boundary(db, "DB") {
        ComponentDb(musics, "musics")
        ComponentDb(user_music, "user_music")
        ComponentDb(db-music_memo, "music_memo")
    }

    BiRel(user, mylist-assistant, "")
    BiRel(mylist-assistant, mylist-assistant-view-model, "")
    BiRel(mylist-assistant-view-model, mylist-assistant-controller, "")
    BiRel(mylist-assistant-controller, mylist-assistant-service, "")
    BiRel(mylist-assistant-service, music, "")
    BiRel(mylist-assistant-service, user-music, "")
    BiRel(mylist-assistant-service, model-music_memo, "")
    BiRel(music, musics, "")
    BiRel(user-music, user_music, "")
    BiRel(model-music_memo, db-music_memo, "")
```

## ER Diagram

```mermaid
erDiagram
    users

    musics {
        bigint id PK
        varchar title
        varchar niconico_id
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    user_music {
        bigint id PK
        bigint user_id
        bigint music_id
        tinyint favorite
        tinyint skip
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    music_memo {
        bigint id PK
        bigint user_id
        bigint music_id
        text memo
        timestamp created_at
        timestamp updated_at
        timestamp deleted_at
    }

    users ||--o{ user_music : ""
    musics ||--o{ user_music : ""
    users ||--o{ music_memo : ""
    musics ||--o{ music_memo : ""
```

## Class Diagram

```mermaid
classDiagram
    class SeleniumService {
        #driver: CustomRemoteWebDriver
        -is_driver_disposed: bool
        +openPage(string $url): void
        +getWebElementByCssSelector(string $cssSelector): RemoteWebElement
        +clickButton(RemoteWebElement $button): void
        +typeInInput(RemoteWebElement $input, string $text): void
        +clickAlertOK(): void
        +waitForElement(string $cssSelector, int $timeout): void
        +saveScreenshot(string $filename): void
        +quit(): void
        -setupDriver(string $host): void
        -checkDriverDisposed(): void
        -handleError(WebDriverException $ex): void
    }

    class MylistAssistantSeleniumService {
        +loginNiconico(string $email, string $password): void
        +createMylist(string $mylist_name): void
        +deleteMylist(string $mylist_name): void
        +addVideoToMylist(string $video_id, string $mylist_name): void
        #getAllMylistName(): array
    }

    SeleniumService <|.. MylistAssistantSeleniumService
```
