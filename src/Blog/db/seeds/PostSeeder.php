<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class PostSeeder extends AbstractSeed
{
    
    public function run()
    {
        $data = [];
        $faker = Factory::create('en_US');
        for ($i=0; $i < 100; $i++) {
            $date = $faker->unixTime('now');
            $data[] = [
                'name' => $faker->catchPhrase,
                'slug' => $faker->slug,
                'content' => $faker->text(3000),
                'created_at' => date('Y-m-d H:i:s', $date),
                'updated_at' => date('Y-m-d H:i:s', $date)
            ];
        }
        $this->table('posts')
            ->insert($data)
            ->save();
    }
}
