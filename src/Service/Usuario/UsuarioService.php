<?php 

namespace App\Service\Usuario;

use App\Entity\Usuario;
use App\Exception\Usuario\SenhaObrigatoriaException;
use App\Exception\Usuario\UsuarioInativoException;
use App\Repository\UsuarioRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsuarioService 
{
    public function __construct(
        private UsuarioRepository $usuarioRepository,
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

    public function editar(Usuario $usuario, ?string $senhaNova = null) 
    {
        if (!empty($senhaNova)) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $usuario,
                $senhaNova
            );
            $usuario->setPassword($hashedPassword);
        }

        $this->usuarioRepository->salvar($usuario);
    }

    public function inativar(Usuario $usuario): void
    {
        $usuario->setAtivo(false);
        $this->usuarioRepository->salvar($usuario);
    }

    public function verificaStatusUsuario(Usuario $usuario): void
    {
        if (!$usuario instanceof $usuario) {
            return;
        }

        if ($usuario->isAtivo() === false) {
            throw new UsuarioInativoException();
        }
    }

    public function reativar(Usuario $usuario): void
    {
        $usuario->setAtivo(true);
        $this->usuarioRepository->salvar($usuario);
    }
}
