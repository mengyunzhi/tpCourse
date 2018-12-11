package com.mengyunzhi.datasheet.entity;

import javax.persistence.*;
import java.sql.Timestamp;

@Entity
public class ContributionRecord {

    @Id                                                      //Id为主键自增
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Integer id;                                      // 记录Id(主键)

    private Float contribution;                              // 贡献值

    private Timestamp time;                                  //上传时间

    private String title;                                    //标题

    private String reposiporyName;                           //仓库名

    private String pullRequestUrl;                           //pull request

    private String remark;                                   //备注

    private Integer studentId;                               //学生Id(副键)


    @ManyToOne                                               // 贡献值记录和学生的关联n：1
    private Student student;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Float getContribution() {
        return contribution;
    }

    public void setContribution(Float contribution) {
        this.contribution = contribution;
    }

    public Timestamp getTime() {
        return time;
    }

    public void setTime(Timestamp time) {
        this.time = time;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public String getReposiporyName() {
        return reposiporyName;
    }

    public void setReposiporyName(String reposiporyName) {
        this.reposiporyName = reposiporyName;
    }

    public String getPullRequestUrl() {
        return pullRequestUrl;
    }

    public void setPullRequestUrl(String pullRequestUrl) {
        this.pullRequestUrl = pullRequestUrl;
    }

    public String getRemark() {
        return remark;
    }

    public void setRemark(String remark) {
        this.remark = remark;
    }

    public Integer getStudentId() {
        return studentId;
    }

    public void setStudentId(Integer studentId) {
        this.studentId = studentId;
    }

    public Student getStudent() {
        return student;
    }

    public void setStudent(Student student) {
        this.student = student;
    }
}
