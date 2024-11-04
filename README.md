Тестове завдання:

Створити два додатки з використанням фреймворк Symfony6:

1. Сервер з записами API.
2. Клієнт.

1. Сервер зберігає користувачів та групи у базі даних MySQL.
   Таблиця користувачів має поля: id, name, email.
   Таблиця груп має поля: id, name.

2. Клієнт CLI звертається до сервера через API.
   Має мати можливість створювати, редагувати, видаляти користувачів та групи на сервері(CRUD).
   Має мати можливість отримувати дані з сервера зі списком користувачів кожної групи.

3. Завантажити рішення на GitHub.

Як завантажити та використовувати додатки:

Клонуємо репозиторій та встановлюємо додаток API:
1. Клонуємо з репозиторію:
      git clone git@github.com:KondratenkoS/symfony_api_cli.git

2. Заходимо до директорії - symfony_api:
      cd symfony_api

3. Піднімаємо контейнери з ключем --build(у подальшому використовуємо команду ./run.sh):
      docker compose up --build -d

4. Заходимо у контейнер:
      docker compose exec server bash

5. Встановлюємо пакети:
      composer install

6. Виконуємо міграції, виходимо з контейнера і з директорії symfony_api:
      php bin/console doctrine:migrations:migrate
      exit
      cd ../


Встановлюємо додаток CLI:
1. Їдемо у директорію symfony_cli:
        cd symfony_cli

2. Піднімаємо контейнери з ключем --build(у подальшому використовуємо команду ./run.sh):
        docker compose up --build -d

3. Встановлюємо зв'язок між додатками:
        docker network connect symfony_cli_internal api_server

4. Заходимо у контейнер:
        docker compose exec server bash

5. Встановлюємо пакети:
        composer install

Готово, можемо використовувати консоль для запитів.
Команди для використання:
БД порожня, тож перш за все створюємо користувачів та групи:

    php bin/console AddUserCommand "Ім'я користувача" "email користувача"  - команда створеня користувача;
    php bin/console AddGroupCommand "Назва групи"                          - команда створеня користувача;
    php bin/console AddUserToGroupCommand "ID користувача" "ID групи"      - команда додавання користувача до групи;
    php bin/console ShowAllUsersOfGroup "ID групи"                         - команда виводу всіх користувачів групи;

    php bin/console DeleteUserCommand "ID користувача"                     - команда видалення користувача;
    php bin/console EditUserCommand "ID користувача"                       - команда редагування користувача;
    php bin/console ShowUserCommand "ID користувача"                       - команда виводу одного користувача;
    php bin/console ViewUserCommand                                        - команда виводу всіх користувачів;

    php bin/console DeleteGroupCommand "ID групи"                          - команда видалення групи;
    php bin/console EditGroupCommand "ID групи"                            - команда редагування групи;
    php bin/console ShowGroupCommand "ID групи"                            - команда виводу однієї групи;
    php bin/console ViewGroupCommand                                       - команда виводу всіх груп;
