<?php

namespace AppBundle\Entity;

/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends \Doctrine\ORM\EntityRepository
{

    public function getNews(int $id)
    {
        $entityManager = $this->getEntityManager();
        $news = $entityManager->getRepository('AppBundle:News')->findOneById($id);
        $views = $news->getNumberOfViews();
        $news->setNumberOfViews(++$views);
       /* $similar = $news->getSimilarNewsId();
        array_push($similar,'19');
        $news->setSimilarNewsId($similar);*/
        $entityManager->persist($news);
        $entityManager->flush();
        return $news;
    }

    public function getSimilarNewsFromDataBase(int $id)
    {

        $entityManager = $this->getEntityManager();
        $news = $entityManager->getRepository('AppBundle:News')->findOneById($id);
        return $news;
    }

    public function getLatestFiveNews()
    {
        $entityManager = $this->getEntityManager();
        $sql = 'SELECT news.name,news.description, news.id  FROM news_portal.news ORDER BY news.created_at DESC LIMIT 5';
        $stmt = $entityManager->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }


}
