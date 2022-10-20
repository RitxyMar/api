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

    //// lista todas las canciones en la base de datos
    /**
     * @Route("/cancion", name="cancion_index", methods={"GET"})
     */
    public function indexCanciones(ManagerRegistry $doctrine, Request $request): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }

        $canciones = $doctrine
            ->getRepository(Cancion::class)
            ->findAll();
 
        $data = [];
 
        foreach ($canciones as $cancion) {
           $data[] = [
               'id' => $cancion->getId(),
               'titulo' => $cancion->getTitulo(),
               'artista' => $cancion->getArtista(),
               
           ];
        }
 
 
        return $this->json($data);
    }



    ///// lista todas las listas creadas en la base de datos
     /**
     * @Route("/lista", name="lista_index", methods={"GET"})
     */
    public function indexLista(ManagerRegistry $doctrine, Request $request): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }

        $listas = $doctrine
            ->getRepository(Lista::class)
            ->findAll();
 
        $data = [];
 
        foreach ($listas as $lista) {
           $data[] = [
               'id' => $lista->getId(),
               'nombre' => $lista->getName(),
               'user' => $lista->getUsuarioId()->__toString(),
           ];
        }
 
 
        return $this->json($data);
    }
 

    //// Añade una nueva cancion a una lista la base de datos
    /**
     * @Route("/cancion", name="cancion_new", methods={"POST"})
     */
    public function newCancion(ManagerRegistry $doctrine, Request $request): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }

        $entityManager = $doctrine->getManager();

        $data = json_decode($request->getContent(), true);
        $lista = $entityManager->getRepository(Lista::class)->findOneBy(['id' => $data['lista']]);
        $titulo = $data['titulo'];
        $artista = $data['artista'];
 
        $cancion = new Cancion();
        $cancion->setListaId($lista);
        $cancion->setTitulo($titulo);
        $cancion->setArtista($artista);
 
        $entityManager->persist($cancion);
        $entityManager->flush();
 
        return $this->json('Nueva cancion creada con exito en la lista-> ' . $lista->getId());
    }


    //// Añade unha nueva lista a la base de datos
    /**
     * @Route("/lista", name="lista_new", methods={"POST"})
     */
    public function newLista(ManagerRegistry $doctrine, Request $request): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }
        
        $entityManager = $doctrine->getManager();

        $data = json_decode($request->getContent(), true);
        $usuario = $entityManager->getRepository(User::class)->findOneBy(['id' => $data['usuario']]);
        $name = $data['name'];
 
        $lista = new Lista();
        $lista->setUsuarioId($usuario);
        $lista->setName($name);
 
        $entityManager->persist($lista);
        $entityManager->flush();
 
        return $this->json('Nueva lista creada con exito -> ' . $lista->getId());
    }
 

    ////// Muestra unam lista por id 
    /**
     * @Route("/lista/{id}", name="lista_show", methods={"GET"})
     */
    public function showLista(ManagerRegistry $doctrine, int $id): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }

        $lista = $doctrine
            ->getRepository(Lista::class)
            ->find($id);
 
        if (!$lista) {
 
            return $this->json('No se encontro canción para la id=' . $id, 404);
        }
 
        $data =  [
            'id' => $lista->getId(),
            'nombre' => $lista->getName(),
            'user' => $lista->getUsuarioId(),
           
        ];
         
        return $this->json($data);
    }

    /// edita una lista 
    /**
     * @Route("/lista/{id}", name="lista_edit", methods={"PUT"})
     */
    public function editLista(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }

        $entityManager = $doctrine->getManager();
        $lista = $entityManager->getRepository(Lista::class)->find($id);
 
        if (!$lista) {
            return $this->json('No existe lista par esta id' . $id, 404);
        }

        $entityManager = $doctrine->getManager();
        $cancion = $entityManager->getRepository(Cancion::class)->findName($id);

 
        $lista->setName($request->request->get('name'));
        $lista->setDescription($request->request->get('description'));
        $cancion->setLista($id);
        $entityManager->flush();
 
       
        $data =  [
            'id' => $lista->getId(),
            'nombre' => $lista->getName(),
            'user' => $lista->getUsuarioId(),
           
        ];
         
         
        return $this->json($data);
    }

    /// lista a tdos los usuarios 
    /**
     * @Route("/user", name="user_index", methods={"GET"})
     */
    public function indexUser(ManagerRegistry $doctrine): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }

        $users = $doctrine
            ->getRepository(User::class)
            ->findAll();
 
        $data = [];
        foreach ($users as $user) {
            $listas = [];
            foreach ($user->getListas() as $lista) {
                $canciones = [];
                foreach ($lista->getCanciones() as $cancion) {
                    $canciones[] = [
                        'titulo' => $cancion->getTitulo(),
                        'artista' => $cancion->getArtista(),
                    ];
                }

                $listas[] = [
                    'id' => $lista->getId(),
                    'nombre' => $lista->getName(),
                    'canciones' => $canciones
                ];
            }

           $data[] = [
               'id' => $user->getId(),
               'nombre' => $user->getNombre(),
               'listas' => $listas
           ];
        }
 
 
        return $this->json($data);
    }

    /// mustra un usuario por id 
     /**
     * @Route("/user/{id}", name="user_show", methods={"GET"})
     */
    public function showUser(ManagerRegistry $doctrine, int $id): Response
    {
        $usuarioExiste = $this->checkUsuario($doctrine, $request);
        if (!$usuarioExiste) {
            return $this->json('El usuario proporcionado no existe');
        }

        $user = $doctrine
            ->getRepository(User::class)
            ->find($id);
 
        if (!$user) {
 
            return $this->json('No se el usuario con la id=' . $id, 404);
        }
 
        $data = [];
        
            $listas = [];
            foreach ($user->getListas() as $lista) {
                $canciones = [];
                foreach ($lista->getCanciones() as $cancion) {
                    $canciones[] = [
                        'titulo' => $cancion->getTitulo(),
                        'artista' => $cancion->getArtista(),
                    ];
                }

                $listas[] = [
                    'id' => $lista->getId(),
                    'nombre' => $lista->getName(),
                    'canciones' => $canciones
                ];
            }

           $data[] = [
               'id' => $user->getId(),
               'nombre' => $user->getNombre(),
               'listas' => $listas
           ];
        
 
         
        return $this->json($data);
    }
 
    /**
     * Comprobación de que el usuario exista en la base de datos
     * 
     * @return bool
     */
    public function checkUsuario(ManagerRegistry $doctrine, Request $request){
        $usuario = !empty($request->headers->get('php-auth-user')) ? $request->headers->get('php-auth-user') : '';
        $pass = !empty($request->headers->get('php-auth-pw')) ? $request->headers->get('php-auth-pw') : '';

        $usuario = $doctrine->getRepository(User::class)->findBy([
            'nombre' => $usuario,
            'password' => $pass
        ]);

        if (!empty($usuario) && !empty($usuario[0])) {
            return true;
        } else {
            return false;
        }
    }
}