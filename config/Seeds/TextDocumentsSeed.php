<?php
use Migrations\AbstractSeed;

/**
 * TextDocuments seed.
 */
class TextDocumentsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'document_id' => '1',
                'text' => 'A frog is any member of a diverse and largely carnivorous group of short-bodied, tailless amphibians composing the order Anura (Ancient Greek ἀν-, without + οὐρά, tail). The oldest fossil \'proto-frog\' appeared in the early Triassic of Madagascar, but molecular clock dating suggests their origins may extend further back to the Permian, 265 million years ago. Frogs are widely distributed, ranging from the tropics to subarctic regions, but the greatest concentration of species diversity is in tropical rainforests. There are approximately 4,800 recorded species, accounting for over 85% of extant amphibian species. They are also one of the five most diverse vertebrate orders.

The body plan of an adult frog is generally characterized by a stout body, protruding eyes, cleft tongue, limbs folded underneath, and the absence of a tail. Besides living in fresh water and on dry land, the adults of some species are adapted for living underground or in trees. The skins of frogs are glandular, with secretions ranging from distasteful to toxic. Warty species of frog tend to be called toads but the distinction between frogs and toads is based on informal naming conventions concentrating on the warts rather than taxonomy or evolutionary history. Frogs\' skins vary in colour from well-camouflaged dappled brown, grey and green to vivid patterns of bright red or yellow and black to advertise toxicity and warn off predators.

Frogs typically lay their eggs in water. The eggs hatch into aquatic larvae called tadpoles that have tails and internal gills. They have highly specialized rasping mouth parts suitable for herbivorous, omnivorous or planktivorous diets. The life cycle is completed when they metamorphose into adults. A few species deposit eggs on land or bypass the tadpole stage. Adult frogs generally have a carnivorous diet consisting of small invertebrates, but omnivorous species exist and a few feed on fruit. Frogs are extremely efficient at converting what they eat into body mass. They are an important food source for predators and part of the food web dynamics of many of the world\'s ecosystems. The skin is semi-permeable, making them susceptible to dehydration, so they either live in moist places or have special adaptations to deal with dry habitats. Frogs produce a wide range of vocalizations, particularly in their breeding season, and exhibit many different kinds of complex behaviours to attract mates, to fend off predators and to generally survive.

Frogs are valued as food by humans and also have many cultural roles in literature, symbolism and religion. Frog populations have declined significantly since the 1950s. More than one third of species are considered to be threatened with extinction and over 120 are believed to have become extinct since the 1980s.[1] The number of malformations among frogs is on the rise and an emerging fungal disease, chytridiomycosis, has spread around the world. Conservation biologists are working to understand the causes of these problems and to resolve them. ',
            ],
            [
                'id' => '2',
                'document_id' => '2',
                'text' => 'I think that I shall never see
A poem lovely as a tree.

A tree whose hungry mouth is prest
Against the earth’s sweet flowing breast;

A tree that looks at God all day,
And lifts her leafy arms to pray;

A tree that may in Summer wear
A nest of robins in her hair;

Upon whose bosom snow has lain;
Who intimately lives with rain.

Poems are made by fools like me,
But only God can make a tree.',
            ],
        ];

        $table = $this->table('text_documents');
        $table->insert($data)->save();
    }
}
