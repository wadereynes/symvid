<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach($this->CommentData() as [$content, $user, $video, $created_at])
        {
            $comment = new Comment;
            $user = $manager->getRepository(User::class)->find($user);
            $video = $manager->getRepository(Video::class)->find($video);

            $comment->setContent($content);
            $comment->setUser($user);
            $comment->setVideo($video);
            $comment->setCreatedAtForFixtures(new \DateTime($created_at));

            $manager->persist($comment);
        }

        $manager->flush();
    }

    private function commentData(): array
    {
        return [
            ['This is comment', 1, 10, '2024-10-08 12:34:45'],
            ['This is comment2', 2, 10, '2024-10-08 12:34:45'],
            ['This is comment2', 3, 10, '2024-10-08 12:34:45'],
            ['This is comment1', 1, 11, '2024-10-08 12:34:45'],
            ['This is comment2', 2, 11, '2024-10-08 12:34:45'],
            ['This is comment2', 3, 11, '2024-10-08 12:34:45'],
        ];
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
