Event API Demo
========================

This repository contains an implementation of the Events API used in my
[OSCON 2014 talk][1].


Steps to implement the API
--------------------------

First of all, we need to create a new [Symfony2][2] project. Using [Composer][3],
this can be done as follows:

    $ composer create-project symfony/framework-standard-edition . "~2.5"

Next, we need to install the [HydraBundle][4] by adding it as a dependency

    $ composer require ml/hydra-bundle dev-master

registering it in [`AppKernel.php`][5]

```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new ML\HydraBundle\HydraBundle(),
    // ...
);
```

and importing the routes into [`routing.yml`][6]:

```yaml
hydra:
    resource: "@HydraBundle/Controller/"
    type:     annotation
    prefix:   /
```

Now we are ready to implement our simple event API. The first step is to
create a bundle

    $ php app/console generate:bundle --namespace=ML/EventApiBundle --dir=src \
            --format=annotation --no-interaction

(apart from [`MLEventApiBundle.php`][7] we can delete all files in the
{`src/ML/EventApiBundle`][8] folder).

Then we create an entity class representing an event. Doctrine's generator
command is quite helpful in this case:

    $ php app/console generate:doctrine:entity --entity=MLEventApiBundle:Event --format=annotation

We now need to tell the HydraBundle which fields it should expose and to what
concepts they (and the class itself) are mapped. This is as simple as
[adding annotations][9] in the form of

    @Hydra\Expose(iri="http://schema.org/Event")

This is enough information for the HydraBundle to generate a CRUD controller
for us:

    $ php app/console hydra:generate:crud --entity=MLEventApiBundle:Event \
            --route-prefix=/events/ --with-write --no-interaction

We can now [complete the annotation of the Event entity class][10] as we now
have the route to generate the URL of an event as well as routes which we
can use as operations:

```php
/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity
 *
 * @Hydra\Expose(iri="http://schema.org/Event")
 * @Hydra\Id("event_retrieve")
 * @Hydra\Operations( {
 *     "event_replace",
 *     "event_delete"
 * } )
 */
class Event
```

Assuming the database connection was configured properly during the Symfony2
installation, we can now create the database and generate the tables:

    $ php app/console doctrine:database:create
    $ php app/console doctrine:schema:create

In our simple example here, we could use the events collection as the main
entry point. In most cases, however, a separate entry point makes sense. Thus, we
[add a new class representing the main entry point and expose it at the root URL][11]
(the [`getEvents()` method in `EntryPoint`][12] is necessary since the HydraBundle
doesn't support virtual properties yet).

We can now fire up a server for our API

    $ php app/console server:run

and start to interact with it

    $ curl http://127.0.0.1:8000/

Of course, we can also install the [HydraConsole][13] to navigate the API in
the browser.

In order to improve our API a bit and make it more usable in the HydraConsole,
we [introduce a new EventCollection][14] instead of relying on Hydra's Collection
class. This allows us to bind an operation to it.

That's it.


[1]: http://www.oscon.com/oscon2014/public/schedule/detail/34203
[2]: http://symfony.com/
[3]: https://getcomposer.org/
[4]: https://github.com/lanthaler/HydraBundle
[5]: https://github.com/lanthaler/EventApiDemo/blob/master/app/AppKernel.php
[6]: https://github.com/lanthaler/EventApiDemo/blob/master/app/config/routing.yml
[7]: https://github.com/lanthaler/EventApiDemo/blob/master/src/ML/EventApiBundle/MLEventApiBundle.php
[8]: https://github.com/lanthaler/EventApiDemo/tree/master/src/ML/EventApiBundle
[9]: https://github.com/lanthaler/EventApiDemo/commit/8b6172af537b4174d74bf1a59c426c688526dacf
[10]: https://github.com/lanthaler/EventApiDemo/commit/2a9d7b0c75c8ade91d4b6b8295e8437d47879062
[11]: https://github.com/lanthaler/EventApiDemo/commit/bf6634cd74d36a4b5ca382cc067550da2f482054
[12]: https://github.com/lanthaler/EventApiDemo/blob/master/src/ML/EventApiBundle/Entity/EntryPoint.php#L18-L31
[13]: https://github.com/lanthaler/HydraConsole
[14]: https://github.com/lanthaler/EventApiDemo/commit/5c4cca393f01012e2a49adc13ce738cab74d008b
