# MERCURE LEARNING

Application of the [documentation from symfony concerning mercure](https://symfony.com/doc/current/mercure.html)

It uses the [docker integration from dunglas (symfony-docker)](https://github.com/dunglas/symfony-docker) with :
* [mercure-bundle](https://github.com/symfony/mercure-bundle) : the current tested bundle
* [webpack-encore-bundle](https://github.com/symfony/webpack-encore-bundle) : to have a cleaner JS/CSS integration
* [bulma.io](https://bulma.io/) : to have ready-to-uses CSS components

## What is Mercure ?

From the [doc](https://symfony.com/doc/current/mercure.html) :

> Mercure is an open protocol designed from the ground up to publish updates from server to clients. 
> It is a modern and efficient alternative to timer-based polling and to WebSocket.

## Getting Started

From [symfony-docker](https://github.com/dunglas/symfony-docker) : 

> 1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/) (v2.10+)
> 2. Run `docker compose build --pull --no-cache` to build fresh images
> 3. Run `docker compose up` (the logs will be displayed in the current shell)
> 4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
> 5. Run `docker compose down --remove-orphans` to stop the Docker containers.

## What has been done here? 

1. Simple subscription 
2. Multiple subscriptions 
3. Simple subscription (using discover mechanism) 
4. Private subscription 

## License

MIT License.
