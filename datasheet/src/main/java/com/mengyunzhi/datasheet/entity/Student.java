package com.mengyunzhi.datasheet.entity;

import javax.persistence.*;
import java.util.ArrayList;
import java.util.List;

@Entity
public class Student {

    @Id                                                      // Id为主键自增
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                                      // 学生Id(主键)

    private String  name;                                    // 姓名

    private String username;                                 // 用户名

    private String tel;                                      // 电话

    private Float contribution;                              // 贡献值

    private Integer coefficient;                             // 贡献值系数

    private String gitUsername;                              // GIT用户名


    @ManyToMany                                              // 学生课程关联，M：N
    private List<Course> courses = new ArrayList<>();

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

    public String getTel() {
        return tel;
    }

    public void setTel(String tel) {
        this.tel = tel;
    }

    public Float getContribution() {
        return contribution;
    }

    public void setContribution(Float contribution) {
        this.contribution = contribution;
    }

    public Integer getCoefficient() {
        return coefficient;
    }

    public void setCoefficient(Integer coefficient) {
        this.coefficient = coefficient;
    }

    public String getGitUsername() {
        return gitUsername;
    }

    public void setGitUsername(String gitUsername) {
        this.gitUsername = gitUsername;
    }

    public List<Course> getCourses() {
        return courses;
    }

    public void setCourses(List<Course> courses) {
        this.courses = courses;
    }
}
