<?php

namespace App\Repository;

use App\Entity\Diplome;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @method Diplome|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diplome|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diplome[]    findAll()
 * @method Diplome[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiplomeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diplome::class);
    }
    /**
     * @param $form
     * @param $slugger
     * @param $diplome
     */
    public function ScanDiplome($form, $slugger, $diplome, $params)
    {
        $file = $form->get('scan')->getData();
        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename     = $slugger->slug($originalFilename);
            $newFilename      = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
            try {
                $file->move(
                    $params,
                    $newFilename
                );
            } catch (FileException $e) {
                print($e);
            }

            $diplome->setScan($newFilename);
        }
    }
}
