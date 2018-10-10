<?php
use Migrations\AbstractSeed;

/**
 * I18n seed.
 */
class I18nSeed extends AbstractSeed
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
                'locale' => 'fr_CA',
                'model' => 'documentTypes',
                'foreign_key' => '1',
                'field' => 'type',
                'content' => 'Texte',
            ],
            [
                'id' => '2',
                'locale' => 'zh_CN',
                'model' => 'documentTypes',
                'foreign_key' => '1',
                'field' => 'type',
                'content' => '文本',
            ],
            [
                'id' => '3',
                'locale' => 'fr_CA',
                'model' => 'documents',
                'foreign_key' => '1',
                'field' => 'name',
                'content' => 'Grenouilles',
            ],
            [
                'id' => '4',
                'locale' => 'zh_CN',
                'model' => 'documents',
                'foreign_key' => '1',
                'field' => 'name',
                'content' => '青蛙',
            ],
            [
                'id' => '5',
                'locale' => 'fr_CA',
                'model' => 'documents',
                'foreign_key' => '2',
                'field' => 'name',
                'content' => 'Arbres',
            ],
            [
                'id' => '6',
                'locale' => 'zh_CN',
                'model' => 'documents',
                'foreign_key' => '2',
                'field' => 'name',
                'content' => '树木',
            ],
            [
                'id' => '7',
                'locale' => 'fr_CA',
                'model' => 'textDocuments',
                'foreign_key' => '1',
                'field' => 'text',
                'content' => 'Les anoures, Anura, sont un ordre d\'amphibiens. C\'est un groupe, diversifié et principalement carnivore, d\'amphibiens sans queue comportant notamment des grenouilles et des crapauds. Le plus ancien fossile de « proto-grenouille » a été daté du début du Trias à Madagascar, mais la datation moléculaire suggère que leur origine pourrait remonter au Permien, il y a 265 Ma. Les anoures sont largement distribués dans le monde, des tropiques jusqu\'aux régions subarctiques, mais la plus grande concentration d\'espèces se trouve dans les forêts tropicales. Il y a environ 4 800 espèces d\'anoures recensées, représentant plus de 85 % des espèces d\'amphibiens existantes. Il est l\'un des cinq ordres de vertébrés les plus diversifiés.

L\'anoure adulte a communément un corps robuste et sans queue, des yeux exorbités, une langue bifide, des membres repliés sous le reste du corps, prêts pour des bonds à bonne distance. Vivant ordinairement en eau douce et sur le sol, certaines espèces vivent, au stade adulte, sous terre ou dans les arbres. La peau des grenouilles est glandulaire, avec des sécrétions lui donnant un mauvais goût ou la rendant toxique. Certaines espèces, appelées par convention crapauds, ont une peau dite verruqueuse dont les renflements contiennent des toxines glandulaires ; mais par la taxinomie et la phylogénie, certains crapauds sont plus proches des grenouilles que des autres crapauds. La couleur de la peau des grenouilles varie du marron tacheté, gris et vert, propices au mimétisme, à des motifs vifs de rouge ou jaune et noir signalant aux prédateurs leur toxicité.

Les œufs que ces amphibiens pondent dans l\'eau, donnent des larves aquatiques appelées têtards possédant des pièces buccales adaptées à un régime herbivore, omnivore ou planctonophage. Quelques espèces déposent leurs œufs sur terre ou n\'ont pas de stade larvaire. Les grenouilles adultes ont généralement un régime carnivore à base de petits invertébrés, mais il existe des espèces omnivores et certaines mangent des fruits. Les grenouilles sont extrêmement efficaces pour convertir ce qu\'elles mangent en biomasse formant une ressource alimentaire majeure pour des prédateurs secondaires, leur donnant ainsi le rôle de clé de voûte du réseau trophique d\'un grand nombre d\'écosystèmes de la planète.

Leur peau semi-perméable les rendant sensibles à la déshydratation, leur habitat est le plus souvent humide, mais certains ont connu une profonde adaptation à des habitats secs. Les grenouilles ont une riche gamme de cris et chants, en particulier à l\'époque de la reproduction, ainsi qu\'une large palette de comportements sophistiqués pour communiquer entre eux ou se débarrasser d\'un prédateur.

Les populations de grenouilles ont considérablement diminué partout dans le monde depuis les années 1950. Plus d\'un tiers des espèces sont considérées comme menacées d\'extinction et plus de 120 sont soupçonnées d\'avoir disparu depuis les années 1980. Le nombre de malformations chez les grenouilles est à la hausse et une maladie fongique émergente, la chytridiomycose, s\'est propagée dans le monde entier. Les spécialistes de la conservation des espèces cherchent les causes de ces problèmes. Les grenouilles sont consommées par les humains et ont aussi une place notable dans la culture à travers la littérature, le symbolisme et la religion.',
            ],
            [
                'id' => '8',
                'locale' => 'zh_CN',
                'model' => 'textDocuments',
                'foreign_key' => '1',
                'field' => 'text',
                'content' => '无尾目（学名：Anura）是属于两生纲的动物，成体基本无尾，卵一般产于水中，孵化成蝌蚪，用鰓呼吸，经过变态，成体主要用肺呼吸，但多数皮肤也有部分呼吸功能。无尾目是生物从水中走上陆地的第一步，比其他两生纲生物要先进，虽然多数已经可以离开水生活，但繁殖仍然离不开水，卵需要在水中经过变态才能成长。因此不如爬行纲动物先进，爬行纲动物已经可以完全离开水生活。',
            ],
            [
                'id' => '9',
                'locale' => 'fr_CA',
                'model' => 'textDocuments',
                'foreign_key' => '2',
                'field' => 'text',
                'content' => 'Je pense que je ne verrais jamais,
Un poème aussi beau qu’un arbre.

Un arbre dont la bouche affamée se presse
Contre les entrailles douces et généreuses de la terre;

Un arbre qui sans répit contemple Dieu,
Et étend ses bras de feuilles en prière;

Un arbre qui en été peut porter
Un nid d’oiseaux dans ses cheveux;

La neige se couche dans son sein;
Et il connaît l’intimité de la pluie.

Les poèmes sont écrits par des idiots comme moi,
Mais Dieu seul peut créer un arbre.',
            ],
            [
                'id' => '10',
                'locale' => 'zh_CN',
                'model' => 'textDocuments',
                'foreign_key' => '2',
                'field' => 'text',
                'content' => '我想我永远不会看到
一首可爱的诗作为一棵树。

一棵饥肠辘辘的树
对着地球甜美流动的乳房;

一棵树，整天看着上帝，
并举起她多叶的手臂祈祷;

可能在夏天穿的树
她头发里有一群知更鸟;

他的怀抱已经落下了;
谁与雨密切相处。

诗歌是由像我这样的傻瓜制作的，
但只有上帝才能造树。',
            ],
        ];

        $table = $this->table('i18n');
        $table->insert($data)->save();
    }
}
