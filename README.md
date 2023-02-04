# 通过serialize对类进行序列化实现的简单的文件数据库


## 如何使用？

### 创建一个admin表，并写入一条数据
```
(new instance)->table("admin")->insert(["username"=>'admin',"password"=>'123456']);
```

### 更新admin表中admin用户的密码修改为123123
```
(new instance)->table('admin')->update(['username'=>'admin'],['password'=>'123123']);
```

### 
