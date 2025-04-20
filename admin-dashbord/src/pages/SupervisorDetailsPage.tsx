// import React from "react";
import { useNavigate, useParams } from "react-router";
import AddAdminButton from "../components/ui/button/AddAdminButton";
import { ArrowLeft } from "lucide-react";
import UserMetaCard from "../components/UserProfile/UserMetaCard";
import UserInfoCard from "../components/UserProfile/UserInfoCard";
import { useTheme } from "../context/ThemeContext";
import { Supervisor } from "../utils/types";
// import EmployeeTable from "../components/tables/EmployeeTable";
import SupervisorsTable from "../components/tables/SupervisorsTable";
function SupervisorDetailsPage() {
  const { id } = useParams<{ id: string }>();
  const supervisorUserId = Number(id);

  const { supervisors } = useTheme();
  const selectedSupervisor = supervisors.find(
    (supervisor) => supervisor.id === supervisorUserId
  );
  const navigate = useNavigate();
  return (
    <div className="relative ">
      <AddAdminButton
        size="sm"
        variant="outline"
        startIcon={<ArrowLeft className="w-4 h-4" />}
        onClick={() => navigate("/supervisor")}
        className="mb-6 relative top-3 left-3"
      >
        Back
      </AddAdminButton>
      <UserMetaCard user={selectedSupervisor as Supervisor} />
      <UserInfoCard user={selectedSupervisor as Supervisor} />
      <br />
      <br />
      <SupervisorsTable />
    </div>
  );
}

export default SupervisorDetailsPage;
