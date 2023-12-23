# LocalStash PHP Library

**LocalStash** is a simple PHP library for managing local cache storage. It provides methods to create, read, update, and delete data from cache files stored locally.

## Features

- Create and manage local cache storage.
- Set, get, delete, and check the existence of items in the cache.
- Clear individual cache items or all cache data.

## Installation

Clone the repository or download the LocalStash class file and include it in your PHP project.

## Usage

```php
require_once __DIR__ .'path/to/LocalStash.php';

// Initialize LocalStash with optional cache name and path
$localStash = new LocalStash();

// Create local storage and cache files
$localStash->init(['cacheName1', 'cacheName2']);

// Set data in the cache
$localStash->set('key', 'value');

// Get data from the cache
$data = $localStash->get('key');

// Delete data from the cache
$localStash->delete('key');

// Check if a key exists in the cache
$exists = $localStash->exists('key');

// Clear all data in the cache
$localStash->clear();

// Clear all cache files
$localStash->clearAll();

// Delete the entire cache
$localStash->deleteCache();

```

## Configuration

You can configure the cache path and storage name by providing values during object creation.

```php
$localStash = new LocalStash('customStorage', '/path/to/custom/cache/');
```
## Note

```vbnet

Make sure to replace `'path/to/LocalStash.php'` with the correct path to your `LocalStash.php` file.
```

## Happy Caching 😁 
## Bye Bye 👋   

