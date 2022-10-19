<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Cancion;
use App\Entity\Lista;
use App\Entity\User;
 
/**
 * @Route("/api", name="api_")
 */
class CancionController extends AbstractController
{
    /**
     * @Route("/cancion", name="cancion_index", methods={"GET"})
     */
    public function indexCanciones(ManagerRegistry $doctrine): Response
    {
        $canciones = $doctrine
            ->getRepository(Cancion::class)
            ->findAll();
 
        $data = [];
 
        foreach ($canciones as $cancion) {
           $data[] = [
               'id' => $cancion->getId(),
               'titulo' => $cancion->getTitulo(),
               'artista' => $cancion->getArtista(),
               //'lista' => $cancion->getLista(),
           ];
        }
 
 
        return $this->json($data);
    }


     /**
     * @Route("/lista", name="lista_index", methods={"GET"})
     */
    public function indexLista(ManagerRegistry $doctrine): Response
    {
        $listas = $doctrine
            ->getRepository(Lista::class)
            ->findAll();
 
        $data = [];
 
        foreach ($listas as $lista) {
           $data[] = [
               'id' => $lista->getId(),
               'nombre' => $lista->getName(),
               'user' => $lista->getUser(),
               
           ];
        }
 
 
        return $this->json($data);
    }
 
    /**
     * @Route("/cancion", name="cancion_new", methods={"POST"})
     */
    public function newCancion(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
 
        $cancion = new Cancion();
        $cancion->setName($request->request->get('name'));
        $cancion->setDescription($request->request->get('description'));
 
        $entityManager->persist($cancion);
        $entityManager->flush();
 
        return $this->json('Nueva cancion creada con exito' . $cancion->getId());
    }
    
       /**
     * @Route("/lista", name="lista_new", methods={"POST"})
     */
    public function newLista(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
 
        $lista = new Cancion();
        $lista->setName($request->request->get('name'));
        //$lista->setDescription($request->request->get('description'));
 
        $entityManager->persist($cancion);
        $entityManager->flush();
 
        return $this->json('Nueva lista creada con exito' . $cancion->getId());
    }
 
    /**
     * @Route("/lista/{id}", name="lista_show", methods={"GET"})
     */
    public function showLista(ManagerRegistry $doctrine, int $id): Response
    {
        $lista = $doctrine
            ->getRepository(Lista::class)
            ->find($id);
 
        if (!$lista) {
 
            return $this->json('No se encontro canción para la id=' . $id, 404);
        }
 
        $data =  [
            'id' => $lista->getId(),
            'nombre' => $lista->getName(),
            'user' => $lista->getUser(),
           
        ];
         
        return $this->json($data);
    }
 
    /**
     * @Route("/lista/{id}", name="lista_edit", methods={"PUT"})
     */
    public function editLista(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $lista = $entityManager->getRepository(Lista::class)->find($id);
 
        if (!$lista) {
            return $this->json('No project found for id' . $id, 404);
        }
 
        $lista->setName($request->request->get('name'));
        $lista->setDescription($request->request->get('description'));
        $entityManager->flush();
 
       
        $data =  [
            'id' => $lista->getId(),
            'nombre' => $lista->getName(),
            'user' => $lista->getUser(),
           
        ];
         
         
        return $this->json($data);
    }


    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function indexUser(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine
            ->getRepository(User::class)
            ->findAll();
 
        $data = [];
 
        foreach ($users as $user) {
           $data[] = [
               'id' => $user->getId(),
               'nombre' => $user->getNombre(),
               //'lista' => $user->getLista(),
              // 'canciones' => $user->getLista()->getCancion(),
           ];
        }
 
 
        return $this->json($data);
    }

     /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function showUser(ManagerRegistry $doctrine, int $id): Response
    {
        $user = $doctrine
            ->getRepository(User::class)
            ->find($id);
 
        if (!$user) {
 
            return $this->json('No se el usuario con la id=' . $id, 404);
        }
 
        $data =  [
            'id' => $user->getId(),
            'nombre' => $user->getNombre(),
           
        ];
         
        return $this->json($data);
    }
 
 
 
}