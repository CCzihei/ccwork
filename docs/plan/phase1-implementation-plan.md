# Vchat TP8 升级 - Phase 1 实施计划

**版本**：v2.0-Phase1
**分支**：feature/tp8-upgrade
**阶段**：Phase 1 - 基础设施建设
**预计工期**：2-3周
**测试覆盖率目标**：>80%

---

## 一、阶段目标

本阶段的核心目标是搭建完整的 ThinkPHP 8.x 项目骨架，建立测试框架，实现用户认证模块。

### 1.1 关键交付物

- [ ] ThinkPHP 8.x 项目骨架
- [ ] Docker 容器化环境
- [ ] PHPUnit 测试框架配置完成
- [ ] 数据库迁移脚本
- [ ] 用户认证模块（注册、登录、登出）
- [ ] 测试覆盖率 >80%

---

## 二、详细任务分解

### 2.1 创建 ThinkPHP 8.x 项目骨架

**任务 2.1.1：初始化 Composer 项目**

```bash
# 创建项目目录
mkdir vchat-tp8
cd vchat-tp8

# 初始化 Composer 项目
composer init
```

**任务 2.1.2：安装 ThinkPHP 8.x 依赖**

```bash
composer require topthink/framework:^8.0
composer require topthink/think-orm:^3.0
composer require topthink/think-migration:^3.0
```

**任务 2.1.3：配置目录结构**

```
vchat-tp8/
├── app/
│   ├── controller/
│   │   └── api/
│   ├── service/
│   ├── model/
│   └── validate/
├── config/
├── route/
├── tests/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── runtime/
├── storage/
├── docker/
└── .env
```

**TDD 测试点**：
- [ ] 验证目录结构创建成功
- [ ] 验证 Composer 依赖安装成功
- [ ] 验证应用可以正常启动

---

### 2.2 配置 Docker 环境

**任务 2.2.1：创建 Dockerfile**

```dockerfile
FROM php:8.2-fpm

# 安装扩展
RUN docker-php-ext-install pdo pdo_mysql

# 安装 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
```

**任务 2.2.2：创建 docker-compose.yml**

```yaml
version: '3.8'

services:
  nginx:
    image: nginx:alpine
    ports:
      - "80:80"
    volumes:
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
      - ./public:/var/www/html/public
    depends_on:
      - php
    networks:
      - vchat-network

  php:
    build:
      context: ./docker/php
      dockerfile: Dockerfile
    volumes:
      - ./:/var/www/html
    depends_on:
      - mysql
      - redis
    networks:
      - vchat-network

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
      MYSQL_DATABASE: vchat
    ports:
      - "3306:3306"
    networks:
      - vchat-network

  redis:
    image: redis:7-alpine
    ports:
      - "6379:6379"
    networks:
      - vchat-network

volumes:
  mysql-data:

networks:
  vchat-network:
    driver: bridge
```

**任务 2.2.3：创建 Nginx 配置**

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/html/public;
    
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

**TDD 测试点**：
- [ ] 验证 Docker 容器可以正常启动
- [ ] 验证 MySQL 连接成功
- [ ] 验证 Redis 连接成功
- [ ] 验证 Nginx 配置正确

---

### 2.3 配置 PHPUnit 测试框架

**任务 2.3.1：安装 PHPUnit 依赖**

```bash
composer require --dev phpunit/phpunit:^10.0
composer require --dev mockery/mockery:^1.6
composer require --dev fakerphp/faker:^1.23
```

**任务 2.3.2：配置 phpunit.xml**

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="tests/bootstrap.php"
         colors="true"
         cacheDirectory=".phpunit.cache"
         executionOrder="depends,defects"
         requireCoverageMetadata="false"
         beStrictAboutCoverageMetadata="false"
         beStrictAboutOutputDuringTests="true"
         failOnRisky="true"
         failOnWarning="true">
    
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
    </testsuites>
    
    <coverage>
        <include>
            <directory suffix=".php">./app</directory>
        </include>
    </coverage>
</phpunit>
```

**任务 2.3.3：创建 tests/bootstrap.php**

```php
<?php

require __DIR__ . '/../vendor/autoload.php';

// 加载测试环境配置
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

// 设置测试环境
putenv('APP_ENV=testing');
```

**TDD 测试点**：
- [ ] 验证 PHPUnit 可以正常运行
- [ ] 验证 Mockery 可以创建 Mock 对象
- [ ] 验证 Faker 可以生成测试数据
- [ ] 验证覆盖率报告生成

---

### 2.4 设计并创建数据库迁移脚本

#### **迁移 2.4.1：创建用户表**

**RED - 编写测试**

```php
// tests/Unit/Model/UserModelTest.php

public function test_can_create_user()
{
    $user = User::create([
        'name' => 'testuser',
        'password' => password_hash('password123', PASSWORD_BCRYPT),
        'email' => 'test@example.com',
    ]);
    
    $this->assertNotNull($user->id);
    $this->assertEquals('testuser', $user->name);
}

public function test_user_password_is_hashed()
{
    $user = User::create([
        'name' => 'testuser',
        'password' => 'plaintext',
    ]);
    
    $this->assertNotEquals('plaintext', $user->password);
    $this->assertTrue(password_verify('plaintext', $user->password));
}
```

**GREEN - 实现迁移**

```php
// database/migrations/2024_01_01_000001_create_users_table.php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUsersTable extends Migrator
{
    public function up()
    {
        $table = $this->table('users', ['engine' => 'InnoDB', 'collation' => 'utf8mb4_unicode_ci']);
        
        $table->addColumn('name', 'string', ['limit' => 50, 'null' => false])
              ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('email', 'string', ['limit' => 100, 'default' => ''])
              ->addColumn('sex', 'integer', ['signed' => false, 'default' => 0])
              ->addColumn('age', 'integer', ['signed' => false, 'default' => 0])
              ->addColumn('avatar', 'string', ['limit' => 255, 'default' => ''])
              ->addColumn('status', 'integer', ['signed' => false, 'default' => 1])
              ->addColumn('identity', 'integer', ['signed' => false, 'default' => 1])
              ->addColumn('department', 'string', ['limit' => 50, 'default' => '信息工程学院'])
              ->addColumn('last_login_time', 'integer', ['signed' => false, 'default' => 0])
              ->addColumn('last_login_ip', 'string', ['limit' => 45, 'default' => ''])
              ->addColumn('remember_token', 'string', ['limit' => 100, 'default' => ''])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
              ->addColumn('deleted_at', 'timestamp', ['null' => true])
              ->addIndex('name', ['unique' => true])
              ->addIndex('status')
              ->save();
    }
    
    public function down()
    {
        $this->dropTable('users');
    }
}
```

#### **迁移 2.4.2：创建管理员表**

```php
// database/migrations/2024_01_01_000002_create_admin_users_table.php

public function up()
{
    $table = $this->table('admin_users', ['engine' => 'InnoDB']);
    
    $table->addColumn('name', 'string', ['limit' => 50, 'null' => false])
          ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
          ->addColumn('email', 'string', ['limit' => 100, 'default' => ''])
          ->addColumn('last_login_time', 'integer', ['signed' => false, 'default' => 0])
          ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
          ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
          ->addIndex('name', ['unique' => true])
          ->save();
}
```

**TDD 测试点**：
- [ ] 验证迁移可以正常运行
- [ ] 验证表结构正确
- [ ] 验证索引创建成功
- [ ] 验证外键关系正确

---

### 2.5 实现用户认证模块

#### **2.5.1 用户模型 (User Model)**

**RED - 编写测试**

```php
// tests/Unit/Model/UserModelTest.php

namespace Tests\Unit\Model;

use Tests\TestCase;
use app\model\User;

class UserModelTest extends TestCase
{
    public function test_can_find_user_by_name()
    {
        $user = User::findByName('testuser');
        $this->assertInstanceOf(User::class, $user);
    }
    
    public function test_returns_null_for_nonexistent_user()
    {
        $user = User::findByName('nonexistent');
        $this->assertNull($user);
    }
    
    public function test_can_check_user_status()
    {
        $user = User::findByName('testuser');
        $this->assertTrue($user->isActive());
    }
    
    public function test_can_verify_password()
    {
        $user = User::findByName('testuser');
        $this->assertTrue($user->verifyPassword('password123'));
        $this->assertFalse($user->verifyPassword('wrongpassword'));
    }
    
    public function test_can_update_last_login_info()
    {
        $user = User::findByName('testuser');
        $user->updateLastLogin('127.0.0.1');
        
        $this->assertNotEquals(0, $user->last_login_time);
        $this->assertEquals('127.0.0.1', $user->last_login_ip);
    }
    
    public function test_password_is_hidden_in_array()
    {
        $user = User::findByName('testuser');
        $array = $user->toArray();
        
        $this->assertArrayNotHasKey('password', $array);
    }
}
```

**GREEN - 实现模型**

```php
// app/model/User.php

namespace app\model;

use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;
    
    protected $table = 'users';
    protected $pk = 'id';
    protected $hidden = ['password', 'remember_token', 'deleted_at'];
    protected $fillable = [
        'name', 'password', 'email', 'sex', 'age',
        'avatar', 'status', 'identity', 'department'
    ];
    protected $autoWriteTimestamp = true;
    protected $deleteTime = 'deleted_at';
    
    /**
     * 根据用户名查找用户
     */
    public static function findByName(string $name): ?User
    {
        return self::where('name', $name)->find();
    }
    
    /**
     * 检查用户是否激活
     */
    public function isActive(): bool
    {
        return $this->status === 1;
    }
    
    /**
     * 验证密码
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
    
    /**
     * 更新最后登录信息
     */
    public function updateLastLogin(string $ip): bool
    {
        $this->last_login_time = time();
        $this->last_login_ip = $ip;
        return $this->save();
    }
    
    /**
     * 设置密码（自动加密）
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}
```

#### **2.5.2 用户服务 (User Service)**

**RED - 编写测试**

```php
// tests/Unit/Service/UserServiceTest.php

namespace Tests\Unit\Service;

use Tests\TestCase;
use app\service\UserService;
use app\model\User;

class UserServiceTest extends TestCase
{
    private UserService $userService;
    
    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }
    
    public function test_can_register_new_user()
    {
        $data = [
            'name' => 'newuser',
            'password' => 'password123',
            'email' => 'newuser@example.com',
            'identity' => 1,
        ];
        
        $user = $this->userService->register($data);
        
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('newuser', $user->name);
        $this->assertTrue($user->verifyPassword('password123'));
    }
    
    public function test_cannot_register_duplicate_username()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('用户名已存在');
        
        $data = [
            'name' => 'existinguser',
            'password' => 'password123',
        ];
        
        $this->userService->register($data);
        $this->userService->register($data);
    }
    
    public function test_can_login_with_valid_credentials()
    {
        $user = $this->userService->register([
            'name' => 'loginuser',
            'password' => 'password123',
        ]);
        
        $result = $this->userService->login('loginuser', 'password123');
        
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('loginuser', $result->name);
    }
    
    public function test_cannot_login_with_wrong_password()
    {
        $this->userService->register([
            'name' => 'loginuser2',
            'password' => 'password123',
        ]);
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('密码错误');
        
        $this->userService->login('loginuser2', 'wrongpassword');
    }
    
    public function test_cannot_login_disabled_user()
    {
        $user = $this->userService->register([
            'name' => 'disableduser',
            'password' => 'password123',
        ]);
        
        $user->status = 0;
        $user->save();
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('用户已被禁用');
        
        $this->userService->login('disableduser', 'password123');
    }
    
    public function test_can_update_user_profile()
    {
        $user = $this->userService->register([
            'name' => 'updateuser',
            'password' => 'password123',
            'age' => 20,
        ]);
        
        $updatedUser = $this->userService->updateProfile($user->id, [
            'age' => 25,
            'department' => '计算机学院',
        ]);
        
        $this->assertEquals(25, $updatedUser->age);
        $this->assertEquals('计算机学院', $updatedUser->department);
    }
    
    public function test_can_change_password()
    {
        $user = $this->userService->register([
            'name' => 'passuser',
            'password' => 'oldpassword',
        ]);
        
        $result = $this->userService->changePassword(
            $user->id,
            'oldpassword',
            'newpassword'
        );
        
        $this->assertTrue($result);
        $this->assertTrue($user->verifyPassword('newpassword'));
    }
    
    public function test_cannot_change_password_with_wrong_old_password()
    {
        $user = $this->userService->register([
            'name' => 'passuser2',
            'password' => 'oldpassword',
        ]);
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('原始密码错误');
        
        $this->userService->changePassword(
            $user->id,
            'wrongoldpassword',
            'newpassword'
        );
    }
}
```

**GREEN - 实现服务**

```php
// app/service/UserService.php

namespace app\service;

use app\model\User;
use think\exception\ValidateException;

class UserService
{
    /**
     * 用户注册
     */
    public function register(array $data): User
    {
        // 检查用户名是否已存在
        if (User::findByName($data['name'])) {
            throw new \Exception('用户名已存在');
        }
        
        // 创建用户
        $user = new User();
        $user->name = $data['name'];
        $user->setPassword($data['password']);
        $user->email = $data['email'] ?? '';
        $user->identity = $data['identity'] ?? 1;
        $user->sex = $data['sex'] ?? 0;
        $user->age = $data['age'] ?? 0;
        $user->department = $data['department'] ?? '信息工程学院';
        $user->status = 1;
        
        if (!$user->save()) {
            throw new \Exception('用户创建失败');
        }
        
        return $user;
    }
    
    /**
     * 用户登录
     */
    public function login(string $name, string $password): User
    {
        $user = User::findByName($name);
        
        if (!$user) {
            throw new \Exception('用户不存在');
        }
        
        if (!$user->verifyPassword($password)) {
            throw new \Exception('密码错误');
        }
        
        if (!$user->isActive()) {
            throw new \Exception('用户已被禁用');
        }
        
        // 更新登录信息
        $user->updateLastLogin(request()->ip());
        
        return $user;
    }
    
    /**
     * 更新用户资料
     */
    public function updateProfile(int $userId, array $data): User
    {
        $user = User::find($userId);
        
        if (!$user) {
            throw new \Exception('用户不存在');
        }
        
        // 只允许更新特定字段
        $allowedFields = ['email', 'sex', 'age', 'department', 'avatar'];
        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $user->$field = $data[$field];
            }
        }
        
        if (!$user->save()) {
            throw new \Exception('资料更新失败');
        }
        
        return $user;
    }
    
    /**
     * 修改密码
     */
    public function changePassword(int $userId, string $oldPassword, string $newPassword): bool
    {
        $user = User::find($userId);
        
        if (!$user) {
            throw new \Exception('用户不存在');
        }
        
        if (!$user->verifyPassword($oldPassword)) {
            throw new \Exception('原始密码错误');
        }
        
        $user->setPassword($newPassword);
        
        return $user->save();
    }
    
    /**
     * 更新头像
     */
    public function updateAvatar(int $userId, string $avatarPath): User
    {
        $user = User::find($userId);
        
        if (!$user) {
            throw new \Exception('用户不存在');
        }
        
        $user->avatar = $avatarPath;
        
        if (!$user->save()) {
            throw new \Exception('头像更新失败');
        }
        
        return $user;
    }
    
    /**
     * 禁用/启用用户
     */
    public function changeStatus(int $userId, int $status): bool
    {
        $user = User::find($userId);
        
        if (!$user) {
            throw new \Exception('用户不存在');
        }
        
        $user->status = $status;
        
        return $user->save();
    }
}
```

#### **2.5.3 用户验证器 (User Validator)**

**RED - 编写测试**

```php
// tests/Unit/Validate/UserValidatorTest.php

public function test_validates_required_name()
{
    $validator = new UserValidator();
    
    $result = $validator->check(['password' => '123456'], 'register');
    
    $this->assertFalse($result);
    $this->assertArrayHasKey('name', $validator->getError());
}

public function test_validates_name_length()
{
    $validator = new UserValidator();
    
    $result = $validator->check([
        'name' => 'ab',
        'password' => '123456'
    ], 'register');
    
    $this->assertFalse($result);
}

public function test_validates_password_length()
{
    $validator = new UserValidator();
    
    $result = $validator->check([
        'name' => 'validname',
        'password' => '12345'
    ], 'register');
    
    $this->assertFalse($result);
}

public function test_passes_valid_registration_data()
{
    $validator = new UserValidator();
    
    $result = $validator->check([
        'name' => 'validuser',
        'password' => '123456',
        'email' => 'valid@example.com'
    ], 'register');
    
    $this->assertTrue($result);
}
```

**GREEN - 实现验证器**

```php
// app/validate/UserValidator.php

namespace app\validate;

use think\Validate;

class UserValidator extends Validate
{
    protected $rule = [
        'name' => 'require|length:3,50|alphaNum',
        'password' => 'require|length:6,32',
        'email' => 'email',
        'age' => 'number|between:0,150',
        'sex' => 'number|in:0,1,2',
        'identity' => 'number|in:1,2',
    ];
    
    protected $message = [
        'name.require' => '用户名不能为空',
        'name.length' => '用户名长度必须在3-50个字符之间',
        'name.alphaNum' => '用户名只能包含字母和数字',
        'password.require' => '密码不能为空',
        'password.length' => '密码长度必须在6-32个字符之间',
        'email.email' => '邮箱格式不正确',
        'age.number' => '年龄必须是数字',
        'age.between' => '年龄必须在0-150之间',
    ];
    
    protected $scene = [
        'register' => ['name', 'password'],
        'login' => ['name', 'password'],
        'update' => ['email', 'age', 'sex'],
    ];
}
```

#### **2.5.4 用户 API 控制器 (User Controller)**

**RED - 编写 API 测试**

```php
// tests/Feature/Api/UserApiTest.php

namespace Tests\Feature\Api;

use Tests\TestCase;
use app\model\User;

class UserApiTest extends TestCase
{
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/v1/users/register', [
            'name' => 'testuser',
            'password' => 'password123',
            'email' => 'test@example.com',
            'identity' => 1,
        ]);
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'code',
                     'message',
                     'data' => ['id', 'name', 'email']
                 ]);
    }
    
    public function test_user_cannot_register_with_duplicate_name()
    {
        $this->postJson('/api/v1/users/register', [
            'name' => 'duplicateuser',
            'password' => 'password123',
        ]);
        
        $response = $this->postJson('/api/v1/users/register', [
            'name' => 'duplicateuser',
            'password' => 'password123',
        ]);
        
        $response->assertStatus(400);
    }
    
    public function test_user_can_login()
    {
        // 先注册
        $this->postJson('/api/v1/users/register', [
            'name' => 'loginuser',
            'password' => 'password123',
        ]);
        
        // 再登录
        $response = $this->postJson('/api/v1/users/login', [
            'name' => 'loginuser',
            'password' => 'password123',
        ]);
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'code',
                     'message',
                     'data' => ['id', 'name', 'token']
                 ]);
    }
    
    public function test_user_cannot_login_with_wrong_password()
    {
        $this->postJson('/api/v1/users/register', [
            'name' => 'loginuser2',
            'password' => 'password123',
        ]);
        
        $response = $this->postJson('/api/v1/users/login', [
            'name' => 'loginuser2',
            'password' => 'wrongpassword',
        ]);
        
        $response->assertStatus(401);
    }
    
    public function test_authenticated_user_can_get_info()
    {
        // 注册并登录
        $this->postJson('/api/v1/users/register', [
            'name' => 'infouser',
            'password' => 'password123',
        ]);
        
        $loginResponse = $this->postJson('/api/v1/users/login', [
            'name' => 'infouser',
            'password' => 'password123',
        ]);
        
        $token = $loginResponse->json('data.token');
        
        // 获取用户信息
        $response = $this->withHeader('Authorization', "Bearer {$token}")
                         ->getJson('/api/v1/users/info');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => ['id', 'name', 'email', 'avatar']
                 ]);
    }
    
    public function test_unauthenticated_user_cannot_access_protected_routes()
    {
        $response = $this->getJson('/api/v1/users/info');
        
        $response->assertStatus(401);
    }
}
```

**GREEN - 实现控制器**

```php
// app/controller/api/User.php

namespace app\controller\api;

use app\controller\Base;
use app\service\UserService;
use app\validate\UserValidator;
use think\response\Json;

class User extends Base
{
    private UserService $userService;
    
    public function __construct()
    {
        $this->userService = new UserService();
    }
    
    /**
     * 用户注册
     */
    public function register(): Json
    {
        $data = input('post.');
        
        // 验证数据
        $validator = new UserValidator();
        if (!$validator->scene('register')->check($data)) {
            return json(['code' => 400, 'message' => $validator->getError()]);
        }
        
        try {
            $user = $this->userService->register($data);
            
            return json([
                'code' => 200,
                'message' => '注册成功',
                'data' => $user->hidden(['password', 'deleted_at'])->toArray(),
            ]);
        } catch (\Exception $e) {
            return json(['code' => 400, 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * 用户登录
     */
    public function login(): Json
    {
        $data = input('post.');
        
        // 验证数据
        $validator = new UserValidator();
        if (!$validator->scene('login')->check($data)) {
            return json(['code' => 400, 'message' => $validator->getError()]);
        }
        
        try {
            $user = $this->userService->login($data['name'], $data['password']);
            
            // 生成 Token
            $token = $this->generateToken($user);
            
            return json([
                'code' => 200,
                'message' => '登录成功',
                'data' => array_merge(
                    $user->hidden(['password', 'deleted_at'])->toArray(),
                    ['token' => $token]
                ),
            ]);
        } catch (\Exception $e) {
            return json(['code' => 401, 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * 获取当前用户信息
     */
    public function info(): Json
    {
        $user = $this->request->user;
        
        return json([
            'code' => 200,
            'message' => 'success',
            'data' => $user->hidden(['password', 'deleted_at'])->toArray(),
        ]);
    }
    
    /**
     * 更新用户资料
     */
    public function updateProfile(): Json
    {
        $data = input('put.');
        $userId = $this->request->user->id;
        
        try {
            $user = $this->userService->updateProfile($userId, $data);
            
            return json([
                'code' => 200,
                'message' => '更新成功',
                'data' => $user->toArray(),
            ]);
        } catch (\Exception $e) {
            return json(['code' => 400, 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * 修改密码
     */
    public function changePassword(): Json
    {
        $data = input('post.');
        $userId = $this->request->user->id;
        
        try {
            $this->userService->changePassword(
                $userId,
                $data['old_password'],
                $data['new_password']
            );
            
            return json([
                'code' => 200,
                'message' => '密码修改成功',
            ]);
        } catch (\Exception $e) {
            return json(['code' => 400, 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * 上传头像
     */
    public function uploadAvatar(): Json
    {
        $file = request()->file('avatar');
        
        if (!$file) {
            return json(['code' => 400, 'message' => '请选择头像文件']);
        }
        
        // 验证文件
        $validate = ['size' => 2 * 1024 * 1024, 'ext' => 'jpg,jpeg,png,gif'];
        
        try {
            $info = $file->validate($validate)->move('./uploads/avatars/');
            
            if (!$info) {
                return json(['code' => 400, 'message' => $file->getError()]);
            }
            
            $avatarPath = '/uploads/avatars/' . $info->getSaveName();
            $user = $this->userService->updateAvatar($this->request->user->id, $avatarPath);
            
            return json([
                'code' => 200,
                'message' => '上传成功',
                'data' => ['avatar' => $avatarPath],
            ]);
        } catch (\Exception $e) {
            return json(['code' => 400, 'message' => $e->getMessage()]);
        }
    }
    
    /**
     * 生成 Token
     */
    private function generateToken($user): string
    {
        $payload = [
            'user_id' => $user->id,
            'name' => $user->name,
            'exp' => time() + 7 * 24 * 3600, // 7天过期
        ];
        
        return base64_encode(json_encode($payload));
    }
}
```

#### **2.5.5 定义 API 路由**

```php
// route/api.php

use think\facade\Route;

// 用户相关路由
Route::group('api/v1', function () {
    // 公开路由
    Route::post('users/register', 'api.User/register');
    Route::post('users/login', 'api.User/login');
    
    // 需要认证的路由
    Route::group('', function () {
        Route::get('users/info', 'api.User/info');
        Route::put('users/profile', 'api.User/updateProfile');
        Route::post('users/password', 'api.User/changePassword');
        Route::post('users/avatar', 'api.User/uploadAvatar');
        Route::post('users/logout', 'api.User/logout');
    })->middleware(\app\middleware\AuthMiddleware::class);
});
```

#### **2.5.6 实现认证中间件**

**RED - 编写测试**

```php
// tests/Unit/Middleware/AuthMiddlewareTest.php

public function test_middleware_rejects_request_without_token()
{
    $response = $this->getJson('/api/v1/users/info');
    
    $response->assertStatus(401);
}

public function test_middleware_rejects_request_with_invalid_token()
{
    $response = $this->withHeader('Authorization', 'Bearer invalid_token')
                     ->getJson('/api/v1/users/info');
    
    $response->assertStatus(401);
}

public function test_middleware_accepts_request_with_valid_token()
{
    // 先登录获取 token
    $loginResponse = $this->postJson('/api/v1/users/login', [
        'name' => 'testuser',
        'password' => 'password123',
    ]);
    
    $token = $loginResponse->json('data.token');
    
    // 使用 token 访问受保护路由
    $response = $this->withHeader('Authorization', "Bearer {$token}")
                     ->getJson('/api/v1/users/info');
    
    $response->assertStatus(200);
}
```

**GREEN - 实现中间件**

```php
// app/middleware/AuthMiddleware.php

namespace app\middleware;

class AuthMiddleware
{
    public function handle($request, \Closure $next)
    {
        $token = $request->header('Authorization');
        
        if (!$token) {
            return json(['code' => 401, 'message' => '未登录']);
        }
        
        // 解析 Token
        $token = str_replace('Bearer ', '', $token);
        
        try {
            $payload = json_decode(base64_decode($token), true);
            
            // 检查是否过期
            if (isset($payload['exp']) && $payload['exp'] < time()) {
                return json(['code' => 401, 'message' => 'Token已过期']);
            }
            
            // 将用户信息注入到请求中
            $user = \app\model\User::find($payload['user_id']);
            
            if (!$user) {
                return json(['code' => 401, 'message' => '用户不存在']);
            }
            
            $request->user = $user;
            
            return $next($request);
        } catch (\Exception $e) {
            return json(['code' => 401, 'message' => '无效的Token']);
        }
    }
}
```

---

## 三、数据迁移脚本

### 3.1 创建数据迁移脚本

```php
// database/migrations/2024_01_15_000001_migrate_from_chat.php

/**
 * 从旧系统迁移数据
 */
public function up()
{
    // 迁移用户数据
    $oldUsers = Db::connect('old')->table('ch_user')->select();
    
    foreach ($oldUsers as $oldUser) {
        User::create([
            'name' => $oldUser['name'],
            'password' => $this->convertPassword($oldUser['password']),
            'sex' => $oldUser['sex'],
            'age' => $oldUser['age'],
            'avatar' => $oldUser['icon'] ? '/uploads/' . $oldUser['icon'] : '',
            'status' => $oldUser['status'],
            'identity' => $oldUser['identity'],
            'department' => $oldUser['department'],
            'created_at' => date('Y-m-d H:i:s', $oldUser['create_time']),
            'updated_at' => date('Y-m-d H:i:s', $oldUser['modified_time']),
        ]);
    }
    
    // 迁移其他数据...
}

private function convertPassword(string $oldPassword): string
{
    // 旧系统使用 MD5，新系统使用 bcrypt
    // 可以选择：
    // 1. 强制用户重新设置密码
    // 2. 一次性转换为 bcrypt（用户下次登录时）
    return password_hash($oldPassword, PASSWORD_BCRYPT);
}
```

---

## 四、测试覆盖率检查清单

### 4.1 单元测试覆盖率

| 模块 | 测试类 | 目标行覆盖率 |
|------|--------|-------------|
| User Model | UserModelTest.php | >85% |
| User Service | UserServiceTest.php | >90% |
| User Validator | UserValidatorTest.php | >90% |
| Auth Middleware | AuthMiddlewareTest.php | >85% |

### 4.2 功能测试覆盖率

| API 端点 | 测试方法 | 目标覆盖率 |
|----------|---------|-----------|
| POST /api/v1/users/register | UserApiTest::test_user_can_register | 100% |
| POST /api/v1/users/login | UserApiTest::test_user_can_login | 100% |
| GET /api/v1/users/info | UserApiTest::test_authenticated_user_can_get_info | 100% |
| PUT /api/v1/users/profile | UserApiTest::test_user_can_update_profile | 100% |
| POST /api/v1/users/password | UserApiTest::test_user_can_change_password | 100% |

---

## 五、CI/CD 集成

### 5.1 GitHub Actions 配置

```yaml
# .github/workflows/test.yml

name: Test

on:
  push:
    branches: [ feature/tp8-upgrade ]
  pull_request:
    branches: [ feature/tp8-upgrade ]

jobs:
  test:
    runs-on: ubuntu-latest
    
    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_ROOT_PASSWORD: root
          MYSQL_DATABASE: vchat_test
        ports:
          - 3306:3306
        options: >-
          --health-cmd="mysqladmin ping"
          --health-interval=10s
          --health-timeout=5s
          --health-retries=5
      
      redis:
        image: redis:7-alpine
        ports:
          - 6379:6379
    
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: pdo, pdo_mysql
          coverage: xdebug
      
      - name: Install Dependencies
        run: composer install --prefer-dist --no-progress
      
      - name: Run PHPUnit
        run: ./vendor/bin/phpunit --coverage-text
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: vchat_test
      
      - name: Check Coverage
        run: |
          coverage=$(./vendor/bin/phpunit --coverage-text | grep 'Total' | awk '{print $4}')
          if (( coverage < 80 )); then
            echo "Coverage $coverage% is below 80%"
            exit 1
          fi
```

---

## 六、每日任务分配（Phase 1）

### Week 1

| Day | 任务 | 测试点 | 预计时间 |
|-----|------|--------|---------|
| Day 1 | 创建 TP8 项目骨架 | 目录结构验证 | 2h |
| Day 1 | 配置 Composer 依赖 | 依赖安装验证 | 1h |
| Day 2 | 配置 Docker 环境 | 容器启动验证 | 3h |
| Day 3 | 配置 PHPUnit | 测试框架验证 | 2h |
| Day 4 | TDD: User Model | 5个单元测试 | 3h |
| Day 5 | TDD: User Validator | 5个单元测试 | 2h |
| **Day 5** | **覆盖率检查** | **>50%** | **1h** |

### Week 2

| Day | 任务 | 测试点 | 预计时间 |
|-----|------|--------|---------|
| Day 6 | TDD: User Service | 8个单元测试 | 4h |
| Day 7 | TDD: Auth Middleware | 3个单元测试 | 2h |
| Day 8 | 创建数据库迁移脚本 | 迁移测试 | 3h |
| Day 9 | TDD: User API (注册/登录) | 4个功能测试 | 3h |
| Day 10 | TDD: User API (资料/密码) | 4个功能测试 | 3h |
| **Day 10** | **覆盖率检查** | **>70%** | **1h** |

### Week 3

| Day | 任务 | 测试点 | 预计时间 |
|-----|------|--------|---------|
| Day 11 | TDD: JWT 认证流程 | 3个功能测试 | 2h |
| Day 12 | 开发头像上传功能 | 上传测试 | 2h |
| Day 13 | 编写数据迁移脚本 | 迁移验证 | 3h |
| Day 14 | 配置 CI/CD | 自动化测试 | 3h |
| Day 15 | **最终覆盖率检查 & 代码审查** | **>80%** | **2h** |

---

## 七、验收标准

### 7.1 功能验收

- [ ] 用户可以成功注册
- [ ] 用户可以成功登录
- [ ] 用户可以获取个人信息
- [ ] 用户可以更新个人资料
- [ ] 用户可以修改密码
- [ ] 用户可以上传头像
- [ ] 认证中间件正常工作
- [ ] JWT Token 生成和验证正确

### 7.2 测试验收

- [ ] 单元测试总数 > 30个
- [ ] 功能测试总数 > 15个
- [ ] 代码行覆盖率 > 80%
- [ ] 所有测试通过
- [ ] CI/CD 流程正常运行

### 7.3 环境验收

- [ ] Docker 容器正常启动
- [ ] 数据库迁移成功执行
- [ ] Nginx 配置正确
- [ ] 应用可以正常访问

---

## 八、风险评估

| 风险 | 影响 | 概率 | 应对措施 |
|------|------|------|---------|
| Docker 环境配置复杂 | 中 | 中 | 准备备用传统部署方案 |
| 测试覆盖率不达标 | 高 | 低 | 增加测试用例数量 |
| 数据迁移丢失 | 高 | 低 | 分步骤备份，逐步验证 |
| 密码加密方式变更 | 中 | 中 | 设计平滑过渡方案 |

---

## 九、后续计划

### Phase 1 完成后的下一步

1. **代码审查** - 审查 Phase 1 代码质量和测试覆盖率
2. **Phase 2 启动** - 社交核心功能开发（好友、动态）
3. **文档更新** - 更新 API 文档和部署文档
4. **团队评审** - 团队技术评审和反馈

---

**Phase 1 实施计划已完成，准备开始执行。**

