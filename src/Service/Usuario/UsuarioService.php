<?php 

namespace App\Service\Usuario;

use App\Entity\Usuario;
use App\Exception\Usuario\SenhaObrigatoriaException;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioService 
{
    public function __construct(
        private UsuarioRepository $usuarioRepository,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function criar(Usuario $usuario, ?string $senha) 
    {
        if (empty($senha)) {
            throw new SenhaObrigatoriaException(); 
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $usuario,
            $senha
        );
        
        $usuario->setPassword($hashedPassword);
        $this->usuarioRepository->salvar($usuario);
    }

    public function editar(Usuario $usuario) 
    {
        $this->entityManager->flush();
    }

}