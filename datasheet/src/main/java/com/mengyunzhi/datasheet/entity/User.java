package com.mengyunzhi.datasheet.entity;

import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;

@Entity
public class User {

    @Id                                                      //Id为主键自增
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                                      // 用户Id(主键)

    private String name;                                     // 姓名

    private String username;                                 //用户名

    private String password;                                 // 密码

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }
}
