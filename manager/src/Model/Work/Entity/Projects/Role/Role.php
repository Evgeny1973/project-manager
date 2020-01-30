<?php


namespace App\Model\Work\Entity\Projects\Role;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use function foo\func;

/**
 * @ORM\Entity()
 * @ORM\Table(name="work_project_roles")
 */
class Role
{
    /**
     * @var Id
     * @ORM\Column(type="work_projects_role_id")
     * @ORM\Id()
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection | Permission[]
     * @ORM\Column(type="work_projects_role_permissions")
     */
    private $permissions;

    /**
     * Role constructor.
     * @param Id $id
     * @param string $name
     * @param array $permissions
     */
    public function __construct(Id $id, string $name, array $permissions)
    {
        $this->id = $id;
        $this->name = $name;
        $this->setPermissions($permissions);
    }

    public function edit(string $name, array $permissions): void
    {
        $this->name = $name;
        $this->setPermissions($permissions);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions->exists(static function (Permission $current) use ($permission) {
            return $current->isNameEqual($permission);
        });
    }

    public function clone(Id $id, string $name): self
    {
        return new self($id, $name, $this->permissions->toArray());
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions->toArray();
    }


    public function setPermissions(array $names): void
    {
        $this->permissions = new ArrayCollection(array_map(static function(string $name) {
            return new Permission($name);
        }, array_unique($names)));
    }
}