# 通过serialize对类进行序列化实现的简单的文件数据库
今天有一个需求是在openstick上面跑一个项目，需要有数据的存储操作，内存只有128mb，什么数据库都装不上，只能用php来实现一个轻量级的

## 如何使用？

### 创建一个admin表，并写入一条数据
```
(new instance)->table("admin")->insert(["username"=>'admin',"password"=>'123456']);
```

### 更新admin表中admin用户的密码修改为123123
```
(new instance)->table('admin')->update(['username'=>'admin'],['password'=>'123123']);
```

### 删除admin表中的admin用户
```
(new instance)->table('admin')->delete(['username'=>'admin']);
```

### 查询admin表 admin用户的密码
```
(new instance)->table('admin')->where(['username'=>'admin'])->first()['password']
```

### 对获取到的结果进行排序
```
(new instance)->table('admin')->where(['username'=>'admin'])->orderBy('username','desc')
```

### 获取查询的条目数量
```
(new instance)->table('admin')->where(['username'=>'admin'])->count()
```

### 获取第一个查询条目

```
(new instance)->table('admin')->where(['username'=>'admin'])->first()
```

### 获取最后一个

```
(new instance)->table('admin')->where(['username'=>'admin'])->last()
```

### 限制查询条目数量(1-5条)

```
(new instance)->table('admin')->where(['username'=>'admin'])->limit(1,5);
```
### 清空表

```
(new instance)->table('admin')->truncate()
```


