# ramverk-projekt

### Download and install

Start by cloning the repo:
```
git clone https://github.com/mangepong/ramverk-projekt.git
```

You will now need to update composer:

```
composer update
```

Then install all the packages:

```
make install
```

Lastly you need to reset the database:

```
sqlite3 data/db.sqlite < sql/ddl/db_sqlite.sql
```