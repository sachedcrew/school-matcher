# School Matcher - Symfony Module

## Cel projektu

Moduł pozwala dopasować użytkownika do szkoły na podstawie nazwy wpisanej podczas rejestracji.
Obsługuje różne warianty nazw, skróty oraz literówki i zwraca najlepsze dopasowania w postaci tablicy.

## Założenia

* Wpisana nazwa jest porównywana z oficjalnymi nazwami i aliasami szkół.
* Zwracane są najlepsze dopasowania (tablica top N).
* Obsługa scenariuszy brzegowych:

  * brak parametru `name` → HTTP 400
  * pusta nazwa → HTTP 400
  * brak dopasowania → HTTP 404

## Instalacja lokalna (bez Docker)

1. Sklonuj projekt.
2. Zainstaluj zależności:

```
composer install
```

3. Uruchom serwer Symfony:

```
php bin/console server:run
```

4. Endpoint dostępny pod:

```
http://localhost:8000/schools/match?name=<nazwa>
```

## Instalacja z Docker

1. Uruchom Docker Compose:

```
docker-compose up --build
```

2. Endpoint dostępny pod:

```
http://localhost:8000/schools/match?name=<nazwa>
```

## Testy

Projekt zawiera testy jednostkowe dla `SchoolMatcher`.
Aby uruchomić testy:

```
vendor/bin/phpunit
```

Testy sprawdzają m.in.:

* dopasowanie nazwy oficjalnej,
* dopasowanie aliasu,
* ignorowanie wielkości liter (case-insensitive),
* brak dopasowania.

## Przykład użycia endpointu

**Przykład 1: dopasowanie nazwy**

```
GET /schools/match?name=Staszic
```

Odpowiedź JSON:

```
[
  {
    "name": "XIV Liceum Ogólnokształcące im. Stanisława Staszica",
    "city": "Warszawa",
    "type": "liceum"
  }
]
```

**Przykład 2: brak parametru name**

```
GET /schools/match?name=
```

Odpowiedź:

```
{
  "message": "Name is required"
}
```

**Przykład 3: brak dopasowania**

```
GET /schools/match?name=Nieistniejąca Szkoła
```

Odpowiedź:

```
{
  "message": "Not found"
}
```

## Możliwe rozszerzenia

* Bulk match (dopasowanie wielu nazw naraz)
* Zapis wyników dopasowania do pliku CSV/JSON
* Ranking top N dopasowań
* Interfejs front-end do wyszukiwania szkół
* Integracja z bazą danych zamiast pliku tekstowego
